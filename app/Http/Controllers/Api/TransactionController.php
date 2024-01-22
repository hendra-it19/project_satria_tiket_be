<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PostTransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Ticket;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function payment(PaymentRequest $request)
    {
        try{
            $transaction = Transaction::where('transaction_id',$request->transaction_id)->first();
            $transaction->update([
                'status' => 'proses',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);
            $param = array(
                'transaction_details' => array(
                    'order_id' => $transaction->transaction_id,
                    'gross_amount' => $transaction->total_harga,
                ),
                'customer_details' => array(
                    'first_name' => $request->user()->nama,
                    'email' => $request->user()->email,
                ),
                'item_details' => array(
                    [
                        'id'            => $transaction->ticket_id,
                        'price'         => $transaction->harga,
                        'quantity'      => $transaction->jumlah,
                        'name'          => 'Tiket tujuan : '. $transaction->ticket->tujuan.'',
                        'brand'         => 'KM. Satria',
                        'category'      => 'Tiket Transportasi Laut',
                        'merchant_name' => config('app.name'),
                    ],
                ),
                'payment_type' => $request->metode_pembayaran,
                // $request->metode_pembayaran => array(
                //     'enable_callback' => true,
                //     'callback_url' => env('APP_URL') . '/api/payment-callback',
                // ),
            );
            $response = \Midtrans\CoreApi::charge($param);
            return response()->json([
                'status' => true,
                'data' => [
                    'transaksi' => new TransactionResource(Transaction::findOrFail($transaction->id)),
                    'pembayaran' => $response,
                ],
                'errors' => null,
                'message' => 'Proses pengajuan pembayaran berhasil dilakukan!',
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.payment',
            ], 500);
        }
    }

    public function callback(Request $request) : JsonResponse
    {
        try{
            $transaction_id = $request->order_id;
            $transaction_status = $request->result;
            $transaction = Transaction::where('transaction_id', $transaction_id)->first();
            $transaction->update([
                'status' => 'selesai',
            ]);
            return response()->json([
                'status' => true,
                'data' => new TransactionResource(Transaction::findOrFail($transaction->id)),
                'errors' => null,
                'message' => 'Berhasil melakukan pembayaran!',
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.callback',
            ], 500);
        }
    }

    public function transaction(PostTransactionRequest $request): JsonResponse
    {
        try {
            $ticket = Ticket::findOrFail($request->ticket_id);
            $transaction_id = 'satria-' . Carbon::now()->format('dmyhi') . 'sid' . $request->user()->id;
            $harga = $ticket->harga;
            $total_harga = intval($request->jumlah) * intval($harga);
            Transaction::create([
                'transaction_id' => $transaction_id,
                'ticket_id' => $ticket->id,
                'user_id' => $request->user()->id,
                'jumlah' => $request->jumlah,
                'harga' => $harga,
                'total_harga' => $total_harga,
                'status' => 'pending',
            ]);
            $data = Transaction::latest('id')->first();
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Transaksi berhasil, silahkan lakukan pembayaran!',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.transaction',
            ], 500);
        }
    }

    public function transactionList(Request $request): JsonResponse
    {
        try {
            $data = Transaction::with('ticket')->where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get();
            $data = new TransactionCollection($data);
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Daftar transaksi berhasil ditampilkan',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.transactionList',
            ], 500);
        }
    }

    public function listByStatus(Request $request, $status): JsonResponse
    {
        try {
            $data = Transaction::with('ticket')->where('user_id', $request->user()->id)
                ->where('status', $status)
                ->get();
            $data = new TransactionCollection($data);
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Daftar transaksi dengan status ' . strtoupper($status) . ' berhasil ditampilkan',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.listByStatus',
            ], 500);
        }
    }

    public function tes($id){
        try{
            $client = new \GuzzleHttp\Client();
            $auth = 'Basic U0ItTWlkLXNlcnZlci1FRFJHLXZ3dDBmRTN3X21Gb0c4NHZLSm46';
            $response = $client->request('GET', 'https://api.sandbox.midtrans.com/v2/'.$id.'/status', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic U0ItTWlkLXNlcnZlci1FRFJHLXZ3dDBmRTN3X21Gb0c4NHZLSm46',
                ],
            ]);
            return $data = $response->getBody();
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.tes',
            ], 500);
        }
    }
}

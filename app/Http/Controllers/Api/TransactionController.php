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
use Illuminate\Database\Eloquent\Builder;
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

    public function notification(Request $req)
    {
        try {
            $notification_body = json_decode($req->getContent(), true);
            $invoice = $notification_body['order_id'];
            $transaction_id = $notification_body['transaction_id'];
            $status_code = $notification_body['status_code'];
            $order = Transaction::where('transaction_id', $invoice)->first();
            if (!$order)
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan | Pembayaran tidak valid'];
            switch ($status_code) {
                case '200':
                    $order->status = "proses";
                    break;
                case '201':
                    $order->status = "pending";
                    break;
                case '202':
                    $order->status = "selesai";
                    break;
            }
            $order->save();
            return response('Ok', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)->header('Content-Type', 'text/plain');
        }
    }

    public function callback(Request $request): JsonResponse
    {
        try {
            $transaction_id = $request->order_id;
            $transaction_status = $request->result;
            $transaction = Transaction::where('transaction_id', $transaction_id)->first();
            $transaction->update([
                'status' => 'proses',
            ]);
            return response()->json([
                'status' => true,
                'data' => new TransactionResource(Transaction::findOrFail($transaction->id)),
                'errors' => null,
                'message' => 'Berhasil melakukan pembayaran!',
            ], 200);
        } catch (Exception $e) {
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
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);
            $transaction = Transaction::latest('id')->first();
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
                        'name'          => 'Tiket tujuan : ' . $transaction->ticket->tujuan . '',
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
            $url = $response->actions[0]->url;
            $expiry_time = $response->expiry_time;
            $transaction->update([
                'expired' => $expiry_time,
                'qr_url' => $url,
            ]);
            $ticket->update([
                'sisa_stok' => intval($ticket->stok) - $request->jumlah,
            ]);
            return response()->json([
                'status' => true,
                'data' => new TransactionResource($transaction),
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
            if ($status == 'berangkat') {
                $data = Transaction::with('ticket')
                    ->where('user_id', $request->user()->id)
                    ->where('status', 'selesai')
                    ->whereHas('ticket', function (Builder $query) {
                        $query->whereDate('keberangkatan', '<=', Carbon::now())
                            ->whereTime('keberangkatan', '<=', Carbon::now());
                    })->orderBy('id', 'DESC')->get();
            } else if ($status == 'selesai') {
                $data = Transaction::with('ticket')
                    ->where('user_id', $request->user()->id)
                    ->where('status', 'selesai')
                    ->whereHas('ticket', function (Builder $query) {
                        $query->whereDate('keberangkatan', '>=', Carbon::now())
                            ->whereTime('keberangkatan', '>=', Carbon::now());
                    })->orderBy('id', 'DESC')->get();
            } else {
                $data = Transaction::with('ticket')->where('user_id', $request->user()->id)
                    ->where('status', $status)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
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

    public function tes($id)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', env('MIDTRANS_URL') . $id . '/status', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic U0ItTWlkLXNlcnZlci1FRFJHLXZ3dDBmRTN3X21Gb0c4NHZLSm46',
                ],
            ]);
            return $data = $response->getBody();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.tes',
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostTransactionRequest;
use App\Http\Resources\TransactionCollection;
use App\Models\Ticket;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

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
            $data = Transaction::latest('id')->get();
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
            $data = Transaction::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->get();
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
            $data = Transaction::where('user_id', $request->user()->id)
                ->where('status', $status)
                ->get();
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
}

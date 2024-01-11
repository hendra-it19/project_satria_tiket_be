<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history(Request $request): JsonResponse
    {
        try {
            $data = new TransactionCollection(Transaction::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->paginate(10));
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Data riwayat transaksi berhasil ditampilkan!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TransactionController.history',
            ], 500);
        }
    }
}

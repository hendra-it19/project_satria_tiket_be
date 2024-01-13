<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketCollection;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = Ticket::whereDate('keberangkatan', Carbon::now())
                ->whereTime('keberangkatan', '>=', Carbon::now())
                ->get();
            $data = new TicketCollection($data);
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Data tiket hari ini berhasil di tampilkan',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TicketController.list'
            ], 500);
        }
    }

    public function filterDestination($destination): JsonResponse
    {
        try {
            $data = Ticket::where('tujuan', $destination)
                ->whereDate('keberangkatan', '>=', Carbon::now())
                ->whereTime('keberangkatan', '>=', Carbon::now())
                ->get();
            $data = new TicketCollection($data);
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Data tiket hari ini berhasil di tampilkan',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'message' => 'Terdapat kesalahan pada Api/TicketController.filterDestination'
            ], 500);
        }
    }
}

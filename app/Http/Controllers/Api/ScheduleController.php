<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = ScheduleResource::collection(Schedule::latest('updated_at')->get());
            return response()->json([
                'status' => true,
                'data' => $data,
                'errors' => null,
                'message' => 'Daftar jadwal berhasil ditampilkan!',
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'errors' => $e->getMessage(),
                'messaage' => 'Terdapat kesalahan pada Api/ScheduleController.list',
            ], 500);
        }
    }
}

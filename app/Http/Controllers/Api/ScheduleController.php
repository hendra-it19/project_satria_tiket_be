<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = Schedule::orderBy('updated_at', 'asc')->get();
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

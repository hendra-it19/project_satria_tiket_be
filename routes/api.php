<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/schedule', [ScheduleController::class, 'list']);
Route::get('/ticket', [TicketController::class, 'list']);
Route::get('/ticket/{destination}', [TicketController::class, 'filterDestination']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'editProfile']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/transaction', [TransactionController::class, 'transaction']);
    Route::get('/transaction', [TransactionController::class, 'transactionList']);
    Route::get('/transaction/{status}', [TransactionController::class, 'listByStatus']);

    Route::post('/payment', [TransactionController::class, 'payment']);
});

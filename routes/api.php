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
Route::get('/ticket/detail/{id}', [TicketController::class, 'detail']);

Route::get('/payment-callback', [TransactionController::class, 'callback']);
Route::post('/payment/notification/post', [TransactionController::class, 'notification']);

Route::get('/status/{id}', [TransactionController::class, 'tes']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'editProfile']);
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/transaction', [TransactionController::class, 'transaction']);
    Route::get('/transaction', [TransactionController::class, 'transactionList']);
    Route::get('/transaction/detail/{id}', [TransactionController::class, 'transactionDetail']);
    Route::get('/transaction/{status}', [TransactionController::class, 'listByStatus']);
});

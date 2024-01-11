<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('registerPost');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [AuthController::class, 'dashboard']);


    Route::resource('ships', ShipController::class);
    Route::resource('users', UserController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('transactions', TransactionController::class)->only([
        'index',
        'show',
        'destroy',
    ]);
});

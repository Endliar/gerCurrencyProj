<?php

use App\Http\Controllers\GetCurrencyController;
use App\Http\Controllers\AuthController;

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

Route::get('/', [GetCurrencyController::class, 'index']);
Route::prefix('user')->group(function () {
    Route::post('create', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

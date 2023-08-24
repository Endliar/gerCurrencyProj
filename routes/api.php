<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetCurrencyController;
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

Route::get('/', [GetCurrencyController::class, 'index']);
Route::prefix('user')->group(function () {
    Route::post('create', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
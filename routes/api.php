<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\KategoriController;
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

// Auth Santum
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Data
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('barang', BarangController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::post('/penjualan', [PenjualanController::class, 'store']);
    Route::get('/penjualan/riwayat', [PenjualanController::class, 'riwayatUser']);
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
    Route::put('/penjualan/{penjualan}', [PenjualanController::class, 'update']);
    Route::delete('/penjualan/{penjualan}', [PenjualanController::class, 'destroy']);
});

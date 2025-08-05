<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BantuanController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProfileController;
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
    Route::post('/login',    [AuthController::class, 'login']);

    // belum di kirim ke FE
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);
});

// FAQ
Route::post('/faq', [FaqController::class, 'store']);

// Bantuan
Route::apiResource('bantuan', BantuanController::class);

// Data
Route::apiResource('kategori', KategoriController::class);

Route::apiResource('barang', BarangController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::post('/penjualan', [PenjualanController::class, 'store']);
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
    //Route::put('/penjualan/{penjualan}', [PenjualanController::class, 'update']);
    //Route::delete('/penjualan/{penjualan}', [PenjualanController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
    Route::get('/cart/riwayat-transaksi', [CartController::class, 'riwayatUser']);
});

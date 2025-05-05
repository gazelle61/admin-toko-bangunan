<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PenjualanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Data
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('barang', BarangController::class);
Route::apiResource('penjualan', PenjualanController::class);

Route::apiResource('image', ImageController::class);

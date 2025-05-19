<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
Route::prefix('auth')->group(function (){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/me', [AuthController::class, 'me']);
});

Route::get('/auth/redirect', [
    SocialiteController::class, 'redirect'
]);

Route::get('/auth/google/callback', [
    SocialiteController::class, 'callback'
]);

// Data
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('barang', BarangController::class);

Route::prefix('faq')->controller(FaqController::class)->group(function () {
    Route::get('/', 'index');       // /api/faq
    Route::post('/', 'store');      // /api/faq
    Route::get('{id}', 'show');     // /api/faq/{id}
    Route::put('{id}', 'update');   // /api/faq/{id}
    Route::delete('{id}', 'destroy');// /api/faq/{id}
});

Route::apiResource('penjualan', PenjualanController::class);

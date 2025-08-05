<?php

use App\Http\Controllers\Api\SocialiteController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BantuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\SupplierController;
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

Route::get('/', function () {
    return view('welcome');
});

// API ROUTE: Auth Socialite
Route::get('/auth/google', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

// WEB ROUTE: Auth AdminLTE
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// KASIR
Route::prefix('admin')->group(function () {
    Route::resource('kasir', KasirController::class);
    Route::post('kasir/tambah-keranjang', [KasirController::class, 'tambahKeranjang'])->name('kasir.tambahKeranjang');
    Route::delete('kasir/hapus-keranjang/{id}', [KasirController::class, 'hapusDariKeranjang'])->name('kasir.hapusDariKeranjang');
    Route::post('kasir/proses-transaksi', [KasirController::class, 'prosesTransaksi'])->name('kasir.prosesTransaksi');
    Route::delete('kasir/resetKeranjang', [KasirController::class, 'resetKeranjang'])->name('kasir.resetKeranjang');
    Route::get('kasir/nota/{invoice}', [KasirController::class, 'nota'])->name('kasir.nota');
    Route::get('kasir/nota/{invoice}/pdf', [KasirController::class, 'notaPdf'])->name('kasir.notaPdf');
});

Route::get('/admin/barang/search', [BarangController::class, 'search'])->name('barang.search');

// PENJUALAN
Route::prefix('admin')->group(function () {
    Route::resource('penjualan', penjualanController::class);

    Route::get('/penjualan/salin/{transactionId}', [penjualanController::class, 'storeOnline'])->name('penjualan.storeOnline');
});

// BARANG
Route::prefix('admin')->group(function () {
    Route::resource('barang', BarangController::class);
});

// KATEGORI
Route::prefix('admin')->group(function () {
    Route::resource('kategori', KategoriController::class);
});

// PEMBELIAN
Route::prefix('admin')->group(function () {
    Route::resource('pembelian', PembelianController::class);
});

// SUPPLIER
Route::prefix('admin')->group(function () {
    Route::resource('supplier', SupplierController::class);
});

// Form FAQ
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/faq', [BantuanController::class, 'index'])->name('faq.index');
    Route::put('/faq/{id}', [BantuanController::class, 'update'])->name('faq.update');
});

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class OnlineController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Penjualan::with(['details.barang', 'details.kategori']);

    //     // Filter hanya penjualan online, kalau mau semua bisa dihapus
    //     $query->where('source', 'online');

    //     // Search berdasarkan nama penerima atau kontak pelanggan
    //     if ($search = $request->input('search')) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('nama_penerima', 'like', "%{$search}%")
    //                 ->orWhere('kontak_pelanggan', 'like', "%{$search}%");
    //         });
    //     }

    //     // Order terbaru dulu
    //     $penjualans = $query->orderByDesc('tgl_transaksi')->paginate(10);

    //     return view('online.index', compact('penjualans'));
    // }

    // public function show($id)
    // {
    //     // Ambil penjualan beserta detail barang dan kategori
    //     $penjualan = Penjualan::with(['details.barang', 'details.kategori'])
    //         ->where('source', 'online') // pastikan hanya untuk transaksi online
    //         ->findOrFail($id);

    //     return view('online.show', compact('penjualan'));
    // }
}

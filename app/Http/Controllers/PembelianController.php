<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;

class PembelianController extends Controller
{
    public function index()
    {
            $pembelians = Pembelian::with('supplier', 'kategori', 'barang')->latest()->get();
            return view('pembelian.index', compact('pembelians'));
    }
}

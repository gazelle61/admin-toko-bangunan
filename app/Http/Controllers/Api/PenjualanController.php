<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json(Penjualan::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tgl_transaksi' => 'required|date',
            'kategori_id' => 'required|exists:kategori,id',
            'total_pemasukan' => 'required|numeric',
            'jumlah_terjual'=> 'required|integer',
            'kontak_pelanggan' => 'required|string|max:20',
            'bukti_transaksi' => 'required|string',
        ]);

        $penjualan = Penjualan::create($validated);

        return response()->json($penjualan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        return response()->json($penjualan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $penjualan->update($request->all());
        return response()->json($penjualan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return response()->json(null, 204);
    }
}

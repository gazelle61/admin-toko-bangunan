<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Penjualan::with('detail.barang', 'detail.kategori')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'total_pemasukan' => 'required|numeric',
            'kontak_pelanggan' => 'nullable|string|max:20',
            'bukti_transaksi' => 'nullable|string',
            'detail' => 'required|array|min:1',
            'detail.*.barang_id' => 'required|exists:barang,id',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::create([
            'users_id' => auth()->id(),
            'tgl_transaksi' => $validated['tgl_transaksi'],
            'total_pemasukan' => $validated['total_pemasukan'],
            'kontak_pelanggan' => $validated['kontak_pelanggan'] ?? null,
            'bukti_transaksi' => $validated['bukti_transaksi'] ?? null,
            'source' => 'online',
        ]);

        foreach ($validated['detail'] as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $item['barang_id'],
                'kategori_id' => $item['kategori_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
            ]);
        }

        return response()->json([
            'message' => 'Transaksi berhasil.',
            'data' => $penjualan->load('detail')
        ], 201);
    }

    public function riwayatUser(Request $request)
    {
        $user = $request->user();
        $penjualan = Penjualan::with('detail.barang', 'detail.kategori')
            ->where('users_id', $user->id)
            ->orderByDesc('tgl_transaksi')
            ->get();

        return response()->json($penjualan);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['detail.barang', 'detail.kategori'])
            ->where('id', $id)
            ->where('users_id', auth()->id())
            ->first();

        if (!$penjualan) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $penjualan->id,
            'users_id' => $penjualan->users_id,
            'tgl_transaksi' => $penjualan->tgl_transaksi,
            'total_pemasukan' => $penjualan->total_pemasukan,
            'kontak_pelanggan' => $penjualan->kontak_pelanggan,
            'source' => $penjualan->source,
            'detail' => $penjualan->detail->map(function ($item) {
                return [
                    'barang_id' => $item->barang_id,
                    'nama_barang' => $item->barang->nama_barang,
                    'kategori' => $item->kategori->nama_kategori,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->harga_satuan,
                ];
            }),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Penjualan $penjualan)
    // {
    //     $penjualan->update($request->all());
    //     return response()->json($penjualan);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Penjualan $penjualan)
    // {
    //     $penjualan->delete();
    //     return response()->json(null, 204);
    // }
}

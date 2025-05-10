<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Barang::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'ukuran' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'foto_barang' => 'nullable|string',
        ]);

        $barang = Barang::create($validated);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        if($barang->foto_barang){
            $barang->foto_barang = Storage::url('/foto_barang' . $barang->foto_barang);
        }

        return response()->json($barang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $barang->update($request->all());
        return response()->json($barang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::with('kategori')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'ukuran' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'satuan_harga' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'foto_barang' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_barang')) {
            $validated['foto_barang'] = $request->file('foto_barang')->store('foto_barang', 'public');
        }

        $barang = Barang::create($validated);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang
        ], 201);
    }

    public function show(Barang $barang)
    {
        $barang->load('kategori');
        $barang->foto_barang = $barang->foto_barang
            ? asset('storage/' . $barang->foto_barang)
            : null;

        return response()->json($barang);
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'ukuran' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'satuan_harga' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required|string',
            'foto_barang' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_barang) {
                Storage::disk('public')->delete($barang->foto_barang);
            }
            $validated['foto_barang'] = $request->file('foto_barang')->store('foto_barang', 'public');
        }

        $barang->update($validated);

        return response()->json($barang);
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto_barang) {
            Storage::disk('public')->delete($barang->foto_barang);
        }
        $barang->delete();

        return response()->json(null, 204);
    }
}

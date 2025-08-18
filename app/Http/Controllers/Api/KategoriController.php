<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    // Menampilkan semua kategori (tanpa pagination, return JSON)
    public function index()
    {
        return response()->json(Kategori::all());
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        // Simpan file jika ada upload
        if ($request->hasFile('foto_kategori')) {
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori = Kategori::create($validated);

        // Response JSON (status 201 Created)
        return response()->json([
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => $kategori
        ], 201);
    }

    // Tampilkan detail kategori tertentu (include relasi barangs)
    public function show(Kategori $kategori)
    {
        $kategori->load('barangs'); // eager load relasi barang

        // Tambahkan URL full untuk foto
        $kategori->foto_kategori = $kategori->foto_kategori
            ? asset('storage/' . $kategori->foto_kategori)
            : null;

        return response()->json($kategori);
    }

    // Update kategori
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        // Jika ada foto baru, hapus lama
        if ($request->hasFile('foto_kategori')) {
            if ($kategori->foto_kategori) {
                Storage::disk('public')->delete($kategori->foto_kategori);
            }
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori->update($validated);

        return response()->json($kategori);
    }

    // Hapus kategori
    public function destroy(Kategori $kategori)
    {
        if ($kategori->foto_kategori) {
            Storage::disk('public')->delete($kategori->foto_kategori);
        }

        $kategori->delete();

        // return kosong tapi status 204 (No Content)
        return response()->json(null, 204);
    }
}

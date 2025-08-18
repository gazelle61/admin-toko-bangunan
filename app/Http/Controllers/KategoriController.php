<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori (ada fitur search dan pagination)
    public function index(Request $request)
    {
        $query = Kategori::query();

        // Jika ada parameter search, filter berdasarkan nama kategori
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        // Urutkan terbaru dan paginate 10 per halaman
        $kategoris = $query->latest()->paginate(10);

        // Kirim data ke view Blade (admin)
        return view('kategori.index', compact('kategoris'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        // Jika ada upload foto, simpan ke storage
        if ($request->hasFile('foto_kategori')) {
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        // Insert ke database
        Kategori::create($validated);

        // Redirect balik ke daftar kategori dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'foto_kategori' => 'nullable|image',
        ]);

        // Jika ada foto baru, hapus foto lama dan simpan foto baru
        if ($request->hasFile('foto_kategori')) {
            if ($kategori->foto_kategori) {
                Storage::disk('public')->delete($kategori->foto_kategori);
            }
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($kategori->foto_kategori) {
            Storage::disk('public')->delete($kategori->foto_kategori);
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil di hapus!');
    }
}

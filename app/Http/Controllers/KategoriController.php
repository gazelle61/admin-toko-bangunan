<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->latest()->paginate(10);
        return view('kategori.index', compact('kategoris'));
    }


    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        if($request->hasFile('foto_kategori')) {
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        Kategori::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'foto_kategori' => 'nullable|image',
        ]);

        if($request->hasFile('foto_kategori')) {
            if($kategori->foto_kategori) {
                Storage::disk('public')->delete($kategori->foto_kategori);
            }
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if($kategori->foto_kategori) {
            Storage::disk('public')->delete($kategori->foto_kategori);
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil di hapus!');
    }
}

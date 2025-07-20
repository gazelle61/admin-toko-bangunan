<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Kategori::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_kategori')) {
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori = Kategori::create($validated);

        return response()->json($kategori, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        $kategori->foto_kategori = $kategori->foto_kategori
        ? asset('storage/' . $kategori->foto_kategori)
        : null;

        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'foto_kategori' => 'nullable|image',
        ]);

        if ($request->hasFile('foto_kategori')) {
            if ($kategori->foto_kategori) {
                Storage::disk('public')->delete($kategori->foto_kategori);
            }
            $validated['foto_kategori'] = $request->file('foto_kategori')->store('foto_kategori', 'public');
        }

        $kategori->update($validated);

        return response()->json($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->foto_kategori) {
            Storage::disk('public')->delete($kategori->foto_kategori);
        }

        $kategori->delete();

        return response()->json(null, 204);
    }

}

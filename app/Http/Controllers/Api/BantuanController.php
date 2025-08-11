<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bantuan;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function index()
    {
        return response()->json(Bantuan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $bantuan = Bantuan::create($request->only('pertanyaan', 'jawaban'));

        return response()->json([
            'message' => 'Bantuan berhasil ditambahkan!',
            'data' => $bantuan
        ], 201);
    }

    public function show($id)
    {
        $bantuan = Bantuan::find($id);
        if (!$bantuan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($bantuan);
    }

    public function update(Request $request, $id)
    {
        $bantuan = Bantuan::find($id);
        if (!$bantuan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $bantuan->update($request->only('pertanyaan', 'jawaban'));

        return response()->json([
            'message' => 'Bantuan berhasil diperbarui',
            'data' => $bantuan
        ]);
    }

    public function destroy($id)
    {
        $bantuan = Bantuan::find($id);
        if (!$bantuan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $bantuan->delete();

        return response()->json(['message' => 'Bantuan berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function index()
    {
        return response()->json(Faq::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'string',
        ]);

        $bantuan = Faq::create($validated);

        return response()->json([
            'message' => 'Bantuan berhasil ditambahkan!',
            'data' => $bantuan
        ], 201);
    }

    public function show(Faq $bantuan)
    {
        return response()->json($bantuan);
    }

    public function update(Request $request, Faq $bantuan)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'string',
        ]);

        $bantuan->update($validated);

        return response()->json($bantuan);
    }

    public function destroy(Faq $bantuan)
    {
        $bantuan->delete();

        return response()->json(null, 204);
    }
}

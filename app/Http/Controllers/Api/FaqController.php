<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email'=> 'required|email',
            'pertanyaan' => 'required|string',
        ]);

        $faq = Faq::create($validated);

        return response()->json(['message' => 'Pertanyaan berhasil dikirim!'], 201);
    }
}

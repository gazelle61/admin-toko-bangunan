<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(Faq::all());
    }

    public function show($id)
    {
        return response()->json(Faq::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|unique:faq,email',
            'tanya' => 'required|string',
            'jawab' => 'required|string',
        ]);

        $faq = Faq::create([
            'nama_pelanggan' => $data['nama_pelanggan'],
            'email' => $data['email'],
            'tanya' => $data['tanya'],
            'jawab' => $data['jawab'],
        ]);

        return response()->json($faq, 201);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|string|unique:faq,email',
            'tanya' => 'required|string',
            'jawab' => 'required|string',
        ]);

        $faq->update($data);

        return response()->json($faq);
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(null, 204);
    }
}

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
            'user_id' => 'required|exists:user,id',
            'tanya' => 'required|string',
        ]);

        $faq = Faq::create([
            'user_id' => $data['user_id'],
            'tanya' => $data['tanya'],
        ]);

        return response()->json($faq, 201);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:user,id',
            'tanya' => 'required|string',
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

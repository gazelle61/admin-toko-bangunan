<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FaqAnswered;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BantuanController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $faq->jawaban = $request->input('jawaban');
        $faq->is_public = $request->has('is_public');
        $faq->save();

        if ($faq->jawaban && $faq->email) {
            Mail::to($faq->email)->send(new FaqAnswered($faq));
        }

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }
}

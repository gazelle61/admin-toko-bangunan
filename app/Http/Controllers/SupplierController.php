<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::with('kategori');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_supplier', 'like', '%', $request->search . '%');
        }

        $suppliers = $query->latest()->paginate(10);

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('supplier.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:20',
            'alamat_supplier'=> 'required|string'
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $kategori = Kategori::all();
        return view('supplier.edit', compact('supplier', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:20',
            'alamat_supplier'=> 'required|string'
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Data berhasil dihapus!');
    }
}

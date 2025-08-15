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
        $suppliers = Supplier::all();
        return view('supplier.create', compact('kategori', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:15',
            'alamat_supplier' => 'required|string'
        ]);

        if ($request->filled('supplier_existing')) {
            $supplier = Supplier::findOrFail($request->supplier_existing);
        } else {
            $request->validate([
                'nama_supplier' => 'required|string'
            ]);
            $supplier = Supplier::create([
                'nama_supplier' => $request->nama_supplier,
                'kategori_id' => $request->kategori_id,
                'barang_supplyan' => $request->barang_supplyan,
                'kontak_supplier' => $request->kontak_supplier,
                'alamat_supplier' => $request->alamat_supplier,
            ]);
        }

        return redirect()->route('supplier.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $kategori = Kategori::all();
        $suppliers = Supplier::all();
        return view('supplier.edit', compact('supplier', 'kategori', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:15',
            'alamat_supplier' => 'required|string'
        ]);

        if ($request->filled('supplier_existing')) {
            // Ganti ke supplier lama yang sudah ada
            $supplier = Supplier::findOrFail($id);
            $existingSupplier = Supplier::findOrFail($request->supplier_existing);
            $supplier->update([
                'nama_supplier' => $existingSupplier->nama_supplier,
                'kategori_id' => $request->kategori_id,
                'barang_supplyan' => $request->barang_supplyan,
                'kontak_supplier' => $request->kontak_supplier,
                'alamat_supplier' => $request->alamat_supplier,
            ]);
        } else {
            // Update dengan nama baru
            $request->validate([
                'nama_supplier' => 'required|string'
            ]);

            $supplier = Supplier::findOrFail($id);
            $supplier->update([
                'nama_supplier' => $request->nama_supplier,
                'kategori_id' => $request->kategori_id,
                'barang_supplyan' => $request->barang_supplyan,
                'kontak_supplier' => $request->kontak_supplier,
                'alamat_supplier' => $request->alamat_supplier,
            ]);
        }

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Data berhasil dihapus!');
    }
}

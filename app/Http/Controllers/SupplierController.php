<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_supplier', 'like', '%' . $request->search . '%');
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
        $rules = [
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:15',
            'alamat_supplier' => 'required|string',
        ];

        // Kalau pilih nama baru → wajib isi nama_supplier
        if (!$request->filled('supplier_existing')) {
            $rules['nama_supplier'] = 'required|string';
        }

        $validated = $request->validate($rules);

        $supplier = Supplier::create([
            'kategori_id'     => $validated['kategori_id'],
            'nama_supplier'   => $request->supplier_existing
                ? Supplier::findOrFail($request->supplier_existing)->nama_supplier
                : $validated['nama_supplier'],
            'barang_supplyan' => $validated['barang_supplyan'],
            'kontak_supplier' => $validated['kontak_supplier'],
            'alamat_supplier' => $validated['alamat_supplier'],
        ]);

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $kategori = Kategori::all();
        $allSuppliers = Supplier::select('nama_supplier')->distinct()->get();

        return view('supplier.edit', compact('supplier', 'kategori', 'allSuppliers'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'kategori_id' => 'required|exists:kategori,id',
            'barang_supplyan' => 'required|string',
            'kontak_supplier' => 'required|string|max:15',
            'alamat_supplier' => 'required|string',
        ];

        if (!$request->filled('supplier_existing')) {
            $rules['nama_supplier'] = 'required|string';
        }

        $validated = $request->validate($rules);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'kategori_id'     => $validated['kategori_id'],
            'nama_supplier'   => $request->supplier_existing
                ? Supplier::findOrFail($request->supplier_existing)->nama_supplier
                : $validated['nama_supplier'],
            'barang_supplyan' => $validated['barang_supplyan'],
            'kontak_supplier' => $validated['kontak_supplier'],
            'alamat_supplier' => $validated['alamat_supplier'],
        ]);

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Data berhasil dihapus!');
    }
}

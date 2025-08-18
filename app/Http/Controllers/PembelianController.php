<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('supplier', 'kategori');

        if ($request->has('search') && $request->search != '') {
            $query->where('tgl_transaksi', 'like', '%' . $request->search . '%');
        }

        $pembelians = $query->latest()->paginate(10);

        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $kategori = Kategori::all();
        return view('pembelian.create', compact('supplier', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tgl_transaksi' => 'required|date',
            'harga' => 'required|numeric',
            'nota_pembelian' => 'nullable|image',
            'detail' => 'required|array',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.nama_barang' => 'required|string',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('nota_pembelian')) {
            $validated['nota_pembelian'] = $request->file('nota_pembelian')->store('nota_pembelian', 'public');
        }

        $pembelian = Pembelian::create($validated);

        foreach ($request->detail as $d) {
            $pembelian->details()->create([
                'kategori_id' => $d['kategori_id'],
                'nama_barang' => $d['nama_barang'],
                'jumlah' => $d['jumlah'],
                'harga_satuan' => $d['harga_satuan'],
            ]);
        }

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $supplier = Supplier::all();
        $kategori = Kategori::all();

        return view('pembelian.edit', compact('pembelian', 'supplier', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $validated = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tgl_transaksi' => 'required|date',
            'harga' => 'required|numeric',
            'nota_pembelian' => 'nullable|image',
            'detail' => 'required|array',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.nama_barang' => 'required|string',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('nota_pembelian')) {
            if ($pembelian->nota_pembelian) {
                Storage::disk('public')->delete($pembelian->nota_pembelian);
            }
            $validated['nota_pembelian'] = $request->file('nota_pembelian')->store('nota_pembelian', 'public');
        }

        $pembelian->update($validated);

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil diperbarui');
    }

    public function show($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        if ($pembelian->nota_pembelian) {
            Storage::disk('public')->delete($pembelian->nota_pembelian);
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil dihapus!');
    }
}

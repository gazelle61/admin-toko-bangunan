<?php 

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('supplier', 'kategori', 'barang');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $pembelians = $query->latest()->paginate(10);

        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $supplier = Supplier::with('supplier_id');
        $kategori = Kategori::with('kategori_id');
        return view('pembelian.create', compact('supplier', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tgl_transaksi' => 'required|date',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'jumlah_pembelian' => 'required|integer',
            'harga' => 'required|numeric',
            'bukti_transaksi' => 'required|string',
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        Pembelian::create($validated);

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $supplier = Supplier::with('supplier_id');
        $kategori = Kategori::with('kategori_id');

        return view('pembelian.edit', compact('pembelian', 'supplier', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $validated = $request->validate([
            'supplier_id' => 'required|exists:supplier,id',
            'tgl_transaksi' => 'required|date',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'jumlah_pembelian' => 'required|integer',
            'harga' => 'required|numeric',
            'bukti_transaksi' => 'required|string',
        ]);

        if ($request->hasFile('bukti_transaksi')) {
            if ($pembelian->bukti_transaksi) {
                Storage::disk('public')->delete($pembelian->bukti_transaksi);
            }
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        $pembelian->update($validated);

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        if ($pembelian->bukti_transaksi) {
            Storage::disk('public')->delete($pembelian->bukti_transaksi);
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil dihapus!');
    }
}

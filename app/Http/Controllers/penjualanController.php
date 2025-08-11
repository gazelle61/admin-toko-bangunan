<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class penjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with('detail.barang', 'detail.kategori');

        if ($request->has('search') && $request->search != '') {
            $query->where('source', 'like', '%' . $request->search . '%');
        }

        $penjualans = $query->latest()->paginate(10);

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $barang = Barang::all();
        $kategori = Kategori::all();
        return view('penjualan.create', compact('barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'total_pemasukan' => 'required|numeric',
            'kontak_pelanggan' => 'nullable|string|max:20',
            'bukti_transaksi' => 'nullable|image',
            'detail' => 'required|array|min:1',
            'detail.*.barang_id' => 'required|exists:barang,id',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_transaksi')) {
            $buktiPath = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        $penjualan = Penjualan::create([
            'users_id' => null,
            'tgl_transaksi' => $validated['tgl_transaksi'],
            'total_pemasukan' => $validated['total_pemasukan'],
            'kontak_pelanggan' => $validated['kontak_pelanggan'] ?? null,
            'bukti_transaksi' => $buktiPath,
            'source' => 'offline',
        ]);

        foreach ($validated['detail'] as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $item['barang_id'],
                'kategori_id' => $item['kategori_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
            ]);
        }

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function storeOnline($transactionId)
    {
        $trx = Transaction::with('items')->findOrFail($transactionId);

        $alreadySynced = Penjualan::where('source', 'online')->where('tgl_transaksi', $trx->created_at->toDateString())
            ->where('total_pemasukan', $trx->total_harga)
            ->where('kontak_pelanggan', $trx->no_telepon)
            ->exists();

        if ($alreadySynced) {
            return back()->with('warning', 'Transaksi sudah pernah disimpan.');
        }

        $penjualan = Penjualan::create([
            'users_id' => $trx['users_id'] ?? null,
            'tgl_transaksi' => $trx->created_at,
            'total_pemasukan' => $trx->total_harga,
            'kontak_pelanggan' => $trx->no_telepon,
            'bukti_transaksi' => $trx->bukti_transaksi ?? null,
            'source' => 'online',
        ]);

        foreach ($trx['detail'] as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $item['barang_id'],
                'kategori_id' => $item['kategori_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
            ]);
        }

        return back()->with('success', 'Transaksi berhasil disimpan!');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('detail')->findOrFail($id);
        $barang = Barang::all();
        $kategori = Kategori::all();

        return view('penjualan.edit', compact('penjualan', 'barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'total_pemasukan' => 'required|numeric',
            'kontak_pelanggan' => 'nullable|string|max:20',
            'bukti_transaksi' => 'nullable|image',
            'detail' => 'required|array|min:1',
            'detail.*.barang_id' => 'required|exists:barang,id',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        $penjualan = Penjualan::findOrFail($id);

        if ($request->hasFile('bukti_transaksi')) {
            if ($penjualan->bukti_transaksi) {
                Storage::disk('public')->delete($penjualan->bukti_transaksi);
            }

            $penjualan->bukti_transaksi = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        $penjualan->update([
            'users_id' => null,
            'tgl_transaksi' => $validated['tgl_transaksi'],
            'total_pemasukan' => $validated['total_pemasukan'],
            'kontak_pelanggan' => $validated['kontak_pelanggan'] ?? null,
            'bukti_transaksi' => $penjualan->bukti_transaksi,
        ]);

        $penjualan->detail()->delete();

        foreach ($validated['detail'] as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'barang_id' => $item['barang_id'],
                'kategori_id' => $item['kategori_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
            ]);
        }

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil diupdate!');
    }

    public function show($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        if ($penjualan->bukti_transaksi) {
            Storage::disk('public')->delete($penjualan->bukti_transaksi);
        }

        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailKasir;
use App\Models\Kasir;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        $keranjang = session()->get('keranjang', []);
        $totalBelanja = collect($keranjang)->sum('total_item');

        return view('kasir.index', compact('barangs', 'keranjang', 'totalBelanja'));
    }

    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        $keranjang = session('keranjang', []);

        $index = collect($keranjang)->search(fn($item) => $item['barang_id'] == $barang->id);

        if ($index != false) {
            $keranjang[$index]['jumlah_beli'] += $request->jumlah_beli;
            $keranjang[$index]['total_item'] = $keranjang[$index]['jumlah_beli'] * $barang->harga;
        } else {
            $keranjang[] = [
                'barang_id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'harga_satuan' => $barang->harga,
                'jumlah_beli' => $request->jumlah_beli,
                'total_item' => $barang->harga * $request->jumlah_beli,
            ];
        }

        session(['keranjang' => $keranjang]);
        return back()->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function hapusDariKeranjang($id)
    {
        $keranjang = session('keranjang', []);
        $keranjang = collect($keranjang)->reject(fn($item) => $item['barang_id'] == $id)->values()->all();

        session(['keranjang' => $keranjang]);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    public function prosesTransaksi(Request $request)
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $total = collect($keranjang)->sum('total_item');

        $request->validate([
            'pembeli' => 'nullable|string|max:100',
            'jumlah_bayar' => 'required|numeric|min:' . $total,
        ]);

        $kasir = Kasir::create([
            'tgl_transaksi' => now(),
            'pembeli' => $request->pembeli,
            'invoice_kode' => 'TBNT' . now()->format('YmdHis'),
            'total_belanja' => $total,
            'jumlah_bayar' => $request->jumlah_bayar,
            'jumlah_kembali' => $request->jumlah_bayar - $total,
            'catatan' => $request->catatan,
        ]);

        foreach ($keranjang as $item) {
            DetailKasir::create([
                'kasir_id' => $kasir->id,
                'barang_id' => $item['barang_id'],
                'harga_satuan' => $item['harga_satuan'],
                'jumlah_beli' => $item['jumlah_beli'],
                'total_item' => $item['total_item'],
            ]);

            Barang::where('id', $item['barang_id'])->decrement('stok', $item['jumlah_beli']);
        }

        session()->forget('keranjang');
        session()->flash('last_invoice', $kasir->invoice_kode);
        session()->flash('last_total', $total);

        return redirect()->route('kasir.nota', $kasir->invoice_kode)
            ->with('success', 'Transaksi berhasil disimpan.');
    }


    public function resetKeranjang()
    {
        session()->forget('keranjang');
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function nota($invoice)
    {
        $kasir = Kasir::with(['details.barang'])->where('invoice_kode', $invoice)->firstOrFail();

        return view('kasir.nota', [
            'kasir' => $kasir,
            'detail' => $kasir->details,
        ]);
    }
}

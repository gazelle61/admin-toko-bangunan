<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;
use App\Models\DetailKasir;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    // Menampilkan halaman kasir + list barang + keranjang
    public function index()
    {
        $barangs = Barang::all()
            // Barang dengan stok > 0 ditaruh di atas
            ->sortByDesc(function ($barang) {
                return $barang->stok > 0 ? 1 : 0;
            })
            ->values();

        // Ambil keranjang dari session
        $keranjang = session()->get('keranjang', []);
        // Hitung total belanja dari semua item di keranjang
        $totalBelanja = collect($keranjang)->sum('total_item');

        return view('kasir.index', compact('barangs', 'keranjang', 'totalBelanja'));
    }

    // Menambahkan barang ke keranjang
    public function tambahKeranjang(Request $request)
    {
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        // Ambil data barang dari database
        $barang = Barang::findOrFail($request->barang_id);

        // Cek stok kosong
        if ($barang->stok <= 0) {
            return back()->with('error', 'Barang ini sedang habis stoknya.');
        }

        // Cek stok cukup atau tidak
        if ($barang->stok < $request->jumlah_beli) {
            return back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Ambil keranjang yang sudah ada di session
        $keranjang = session('keranjang', []);

        // Cari index barang di keranjang
        $index = collect($keranjang)->search(fn($item) => $item['barang_id'] == $barang->id);

        if ($index !== false) {
            // Kalau barang sudah ada di keranjang, update jumlah beli dan totalnya
            $keranjang[$index]['jumlah_beli'] += $request->jumlah_beli;
            $keranjang[$index]['total_item'] = $keranjang[$index]['jumlah_beli'] * $barang->harga;
        } else {
            // Kalau belum ada, masukkan sebagai item baru
            $keranjang[] = [
                'barang_id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'harga_satuan' => $barang->harga,
                'jumlah_beli' => $request->jumlah_beli,
                'total_item' => $barang->harga * $request->jumlah_beli,
            ];
        }

        // Kurangi stok barang di database
        $barang->decrement('stok', $request->jumlah_beli);

        // Simpan stok yang sudah diambil sementara di session
        $stokSementara = session('stok_sementara', []);
        $stokSementara[$barang->id] = ($stokSementara[$barang->id] ?? 0) + $request->jumlah_beli;
        session(['stok_sementara' => $stokSementara]);

        // Simpan keranjang baru ke session
        session(['keranjang' => $keranjang]);
        return back()->with('success', 'Barang ditambahkan ke keranjang.');
    }

    // Menghapus barang dari keranjang
    public function hapusDariKeranjang($id)
    {
        $keranjang = session('keranjang', []);
        $stokSementara = session('stok_sementara', []);

        // Cari barang di keranjang
        $item = collect($keranjang)->first(fn($item) => $item['barang_id'] == $id);
        if ($item) {
            // Kembalikan stok ke DB
            $barang = Barang::find($id);
            if ($barang) {
                $barang->increment('stok', $stokSementara[$id] ?? $item['jumlah_beli']);
            }
            // Hapus stok sementara dari session
            unset($stokSementara[$id]);
        }

        // Hapus barang dari keranjang
        $keranjang = collect($keranjang)->reject(fn($item) => $item['barang_id'] == $id)->values()->all();

        // Simpan kembali ke session
        session(['keranjang' => $keranjang]);
        session(['stok_sementara' => $stokSementara]);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    // Menyelesaikan transaksi
    public function prosesTransaksi(Request $request)
    {
        $keranjang = session('keranjang', []);

        // Cek kalau keranjang kosong
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Hitung total harga semua barang di keranjang
        $total = collect($keranjang)->sum('total_item');

        // Validasi pembayaran
        $request->validate([
            'pembeli' => 'nullable|string|max:100',
            'jumlah_bayar' => 'required|numeric|min:' . $total,
        ]);

        DB::beginTransaction();
        try {
            // Simpan transaksi ke tabel kasir
            $kasir = Kasir::create([
                'tgl_transaksi' => now(),
                'pembeli' => $request->pembeli,
                'invoice_kode' => 'TBNT' . now()->format('YmdHis'),
                'total_belanja' => $total,
                'jumlah_bayar' => $request->jumlah_bayar,
                'jumlah_kembali' => max($request->jumlah_bayar - $total, 0),
                'catatan' => $request->catatan,
            ]);

            // Simpan detail barang yang dibeli ke tabel detail kasir
            foreach ($keranjang as $item) {
                DetailKasir::create([
                    'kasir_id' => $kasir->id,
                    'barang_id' => $item['barang_id'],
                    'harga_satuan' => $item['harga_satuan'],
                    'jumlah_beli' => $item['jumlah_beli'],
                    'total_item' => $item['total_item'],
                ]);
            }

            // Simpan ringkasan transaksi ke tabel penjualan
            $penjualan = Penjualan::create([
                'users_id' => null,
                'tgl_transaksi' => now()->toDateString(),
                'total_pemasukan' => $total,
                'kontak_pelanggan' => $request->pembeli,
                'bukti_transaksi' => $kasir->invoice_kode,
                'source' => 'offline',
            ]);

            // Simpan detail barang yang dibeli ke tabel penjualan_detail
            foreach ($keranjang as $item) {
                $barang = Barang::find($item['barang_id']);
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'kategori_id' => $barang->kategori_id ?? 1,
                    'jumlah' => $item['jumlah_beli'],
                    'harga_satuan' => $item['harga_satuan'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            // Kalau gagal, balikin stok barang
            $stokSementara = session('stok_sementara', []);
            foreach ($keranjang as $item) {
                $barang = Barang::find($item['barang_id']);
                if ($barang) {
                    $barang->increment('stok', $stokSementara[$item['barang_id']] ?? $item['jumlah_beli']);
                }
            }

            return back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }

        // Bersihkan session keranjang dan stok sementara
        session()->forget(['keranjang', 'stok_sementara']);

        // Simpan data transaksi terakhir untuk keperluan nota
        session()->flash('last_invoice', $kasir->invoice_kode);
        session()->flash('last_total', $total);
        session(['last_keranjang' => $keranjang]);

        return redirect()->route('kasir.nota', $kasir->invoice_kode)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    // Mengosongkan keranjang
    public function resetKeranjang()
    {
        session()->forget('keranjang');
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    // Menampilkan halaman nota
    public function nota($invoice)
    {
        $kasir = Kasir::with(['details.barang'])->where('invoice_kode', $invoice)->firstOrFail();

        return view('kasir.nota', [
            'kasir' => $kasir,
            'detail' => $kasir->details,
        ]);
    }

    // Generate nota dalam bentuk PDF
    public function notaPdf($invoice)
    {
        $kasir = Kasir::with(['details.barang'])->where('invoice_kode', $invoice)->firstOrFail();

        $pdf = Pdf::loadView('kasir.nota_pdf', [
            'kasir' => $kasir,
            'detail' => $kasir->details,
        ])->setPaper([0, 0, 226.77, 600], 'portrait');

        return $pdf->stream("Invoice_{$kasir->invoice_kode}.pdf");
    }
}

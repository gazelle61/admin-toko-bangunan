<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class penjualanController extends Controller
{
    // Menampilkan daftar penjualan
    public function index(Request $request)
    {
        // Ambil data penjualan beserta relasi detail barang dan kategori
        $query = Penjualan::with('details.barang', 'details.kategori');

        // Jika ada keyword pencarian berdasarkan "source"
        if ($request->has('search') && $request->search != '') {
            $query->where('source', 'like', '%' . $request->search . '%');
        }

        // Urutkan terbaru dan paginasi 10 data per halaman
        $penjualans = $query->latest()->paginate(10);

        return view('penjualan.index', compact('penjualans'));
    }

    // Form tambah penjualan
    public function create()
    {
        // Ambil semua data barang dan kategori
        $barang = Barang::all();
        $kategori = Kategori::all();
        return view('penjualan.create', compact('barang', 'kategori'));
    }

    // Simpan penjualan offline (kasir/manual)
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tgl_transaksi' => 'required|date',
            'total_pemasukan' => 'required|numeric',
            'kontak_pelanggan' => 'nullable|string|max:20',
            'detail' => 'required|array|min:1',
            'detail.*.barang_id' => 'required|exists:barang,id',
            'detail.*.kategori_id' => 'required|exists:kategori,id',
            'detail.*.jumlah' => 'required|integer|min:1',
            'detail.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        // Generate kode invoice unik (TBNT + timestamp)
        $invoice_kode = 'TBNT' . now()->format('YmdHis');

        // Simpan data penjualan
        $penjualan = Penjualan::create([
            'users_id' => null, // Belum ada user terkait
            'tgl_transaksi' => $validated['tgl_transaksi'],
            'total_pemasukan' => $validated['total_pemasukan'],
            'kontak_pelanggan' => $validated['kontak_pelanggan'] ?? null,
            'bukti_transaksi' => $invoice_kode, // Simpan kode invoice sebagai bukti
            'source' => 'offline',
        ]);

        // Simpan detail penjualan
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

    // Form edit penjualan
    public function edit($id)
    {
        $penjualan = Penjualan::with('detail')->findOrFail($id);
        $barang = Barang::all();
        $kategori = Kategori::all();

        return view('penjualan.edit', compact('penjualan', 'barang', 'kategori'));
    }

    // Update data penjualan
    public function update(Request $request, $id)
    {
        // Validasi input
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

        // Jika ada file bukti transaksi baru, hapus yang lama
        if ($request->hasFile('bukti_transaksi')) {
            if ($penjualan->bukti_transaksi) {
                Storage::disk('public')->delete($penjualan->bukti_transaksi);
            }

            // Upload file baru
            $penjualan->bukti_transaksi = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
        }

        // Update data penjualan
        $penjualan->update([
            'users_id' => null,
            'tgl_transaksi' => $validated['tgl_transaksi'],
            'total_pemasukan' => $validated['total_pemasukan'],
            'kontak_pelanggan' => $validated['kontak_pelanggan'] ?? null,
            'bukti_transaksi' => $penjualan->bukti_transaksi,
        ]);

        // Hapus semua detail lama, lalu simpan ulang
        $penjualan->details()->delete();

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

    // Lihat detail penjualan + link PDF
    public function show($id)
    {
        $penjualan = Penjualan::with('details.barang', 'details.kategori')->findOrFail($id);
        $pdfUrl = route('penjualan.pdf', $penjualan->id);
        return view('penjualan.show', compact('penjualan', 'pdfUrl'));
    }

    // Hapus penjualan
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        // Hapus bukti transaksi jika ada
        if ($penjualan->bukti_transaksi) {
            Storage::disk('public')->delete($penjualan->bukti_transaksi);
        }

        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus!');
    }

    public function cetakPDF($id)
    {
        $penjualan = Penjualan::with('details.barang', 'details.kategori')->findOrFail($id);

        $pdf = Pdf::loadView('penjualan.pdf', compact('penjualan'))
            ->setPaper('A6', 'potrait');

        return $pdf->stream('Struk-'.$penjualan->bukti_transaksi.'.pdf');
    }
}

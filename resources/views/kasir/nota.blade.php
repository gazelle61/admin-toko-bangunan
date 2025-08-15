@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm p-4 rounded-4">
            <h4 class="mb-4">Nota Transaksi - <strong>#{{ $kasir->invoice_kode }}</strong></h4>
            <div class="mb-3">
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kasir->tgl_transaksi)->format('d/m/Y H:i') }}<br>
                <strong>Pembeli:</strong> {{ $kasir->pembeli ?? '-' }}
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total Item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah_beli }}</td>
                            <td>Rp{{ number_format($item->total_item, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 text-end">
                <h5>Total Belanja: <strong>Rp{{ number_format($kasir->total_belanja, 0, ',', '.') }}</strong></h5>
                <p class="mb-1">Dibayar: Rp{{ number_format($kasir->jumlah_bayar, 0, ',', '.') }}</p>
                <p class="mb-1">Kembalian: Rp{{ number_format($kasir->jumlah_kembali, 0, ',', '.') }}</p>
                <p class="mb-1">Catatan: {{ $kasir->catatan ?? '-' }}</p>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-4">
                <a href="{{ route('kasir.index') }}" class="btn btn-secondary rounded-3 px-4 py-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Kasir</a>
                <hr>
                <a href="{{ route('kasir.notaPdf', $kasir->invoice_kode) }}" class="btn btn-primary rounded-3 px-4 py-2"
                    target="_blank">
                    <i class="bi bi-printer-fill me-1"></i> Cetak Struk
                </a>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <h3>Nota Transaksi - {{ $kasir->invoice_kode }}</h3>
    <p><strong>Tanggal:</strong> {{ $kasir->tgl_transaksi->format('d/m/Y H:i') }}</p>
    <p><strong>Pembeli:</strong> {{ $kasir->pembeli ?? '-' }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>Rp{{ number_format($item->harga_satuan) }}</td>
                <td>{{ $item->jumlah_beli }}</td>
                <td>Rp{{ number_format($item->total_item) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Belanja:</strong> Rp{{ number_format($kasir->total_belanja) }}</p>
    <p><strong>Bayar:</strong> Rp{{ number_format($kasir->jumlah_bayar) }}</p>
    <p><strong>Kembali:</strong> Rp{{ number_format($kasir->jumlah_kembali) }}</p>

    <p><strong>Catatan:</strong> {{ $kasir->catatan }}</p>

    <a href="{{ route('kasir.index') }}" class="btn btn-primary">Kembali ke Kasir</a>
@endsection

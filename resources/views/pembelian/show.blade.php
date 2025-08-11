@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Detail Laporan Penjualan</b></h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Bukti Transaksi</th>
                            <td class="text-center">
                                @if ($penjualan->bukti_transaksi)
                                    <img src="{{ Storage::url($penjualan->bukti_transaksi) }}" alt="bukti_transaksi"
                                        width="100">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $penjualan->tgl_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Total Pemasukan</th>
                            <td>Rp{{ number_format($penjualan->total_pemasukan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Pelanggan</th>
                            <td>{{ $penjualan->kontak_pelanggan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Sumber Penjualan</th>
                            <td>{{ ucfirst($penjualan->source) }}</td>
                        </tr>
                        <tr>
                            <th>Detail Penjualan</th>
                            <td class="mb-0 text-left">
                                <ul class="mb-0 text-left">
                                    @foreach ($penjualan->detail as $d)
                                        <li>
                                            {{ $d->barang->nama_barang ?? '-' }}
                                            {{ $d->jumlah }} x Rp{{ number_format($d->harga_satuan, 0, ',', '.') }}
                                            {{ $d->kategori->nama_kategori ?? '-' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                </div>
            </div>
        </div>
    </section>
@endsection

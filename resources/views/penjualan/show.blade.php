@extends('layouts.admin')

@section('content')
    <style>
        /* Hover zoom */
        .product-image {
            transition: transform 0.3s ease;
            cursor: zoom-in;
            max-height: 300px;
            object-fit: contain;
        }

        .product-image:hover {
            transform: scale(1.1);
        }

        /* Fullscreen overlay */
        .image-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
        }

        .image-overlay img {
            max-width: 90%;
            max-height: 90%;
        }

        .image-overlay:target {
            display: flex;
        }
    </style>

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
                                    <a href="#fotoFull">
                                        <img src="{{ Storage::url($penjualan->bukti_transaksi) }}" alt="Bukti Transaksi"
                                            class="img-fluid rounded shadow product-image">
                                    </a>
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

    <!-- Fullscreen Overlay -->
    @if ($penjualan->bukti_transaksi)
        <div id="fotoFull" class="image-overlay">
            <a href="#"
                style="position:absolute; top:20px; right:30px; color:white; font-size:30px; text-decoration:none;">&times;</a>
            <img src="{{ Storage::url($penjualan->bukti_transaksi) }}" alt="Bukti Transaksi">
        </div>
    @endif
@endsection

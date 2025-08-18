@extends('layouts.admin')

@section('content')
    <style>
        /* Hover zoom */
        .product-image {
            transition: transform 0.3s ease;
            cursor: zoom-in;
            max-height: 400px;
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
                    <h3 class="card-title"><b>Detail Pembelian Barang dari Supplier</b></h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nota Pembelian</th>
                            <td class="text-center">
                                @if ($pembelian->nota_pembelian)
                                    <a href="#notaFull">
                                        <img src="{{ Storage::url($pembelian->nota_pembelian) }}" alt="nota_pembelian"
                                            class="img-fluid rounded shadow product-image" style="max-height:200px;">
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ \Carbon\Carbon::parse($pembelian->tgl_transaksi)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                @foreach ($pembelian->details as $d)
                                    {{ $d->kategori->nama_kategori ?? '-' }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>
                                @foreach ($pembelian->details as $d)
                                    {{ $d->nama_barang ?? '-' }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Pembelian</th>
                            <td>
                                @foreach ($pembelian->details as $d)
                                    {{ $d->jumlah }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Harga satuan</th>
                            <td>
                                @foreach ($pembelian->details as $d)
                                    Rp{{ number_format($d->harga_satuan, 0, ',', '.') }}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Total Pengeluaran</th>
                            <td>Rp{{ number_format($pembelian->harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Fullscreen Overlay -->
    @if ($pembelian->nota_pembelian)
        <div id="notaFull" class="image-overlay">
            <a href="#"
                style="position:absolute; top:20px; right:30px; color:white; font-size:30px; text-decoration:none;">&times;</a>
            <img src="{{ Storage::url($pembelian->nota_pembelian) }}" alt="nota_pembelian">
        </div>
    @endif
@endsection

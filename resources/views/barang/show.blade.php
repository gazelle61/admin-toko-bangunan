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

    <section class="content p-3">
        <div class="container-fluid">
            <h4 class="mb-4"><strong>Detail Barang</strong></h4>

            <div class="row">
                <!-- Foto -->
                <div class="col-md-5 text-center">
                    <a href="#fotoFull">
                        @if ($barang->foto_barang)
                            <img src="{{ Storage::url($barang->foto_barang) }}" alt="{{ $barang->nama_barang }}"
                                class="img-fluid rounded shadow product-image">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </a>
                </div>

                <!-- Detail Barang -->
                <div class="col-md-7">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Barang</th>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ukuran</th>
                            <td>{{ $barang->ukuran }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>{{ $barang->stok }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $barang->deskripsi }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Fullscreen Overlay -->
    <div id="fotoFull" class="image-overlay">
        <a href="#"
            style="position:absolute; top:20px; right:30px; color:white; font-size:30px; text-decoration:none;">&times;</a>
        <img src="{{ Storage::url($barang->foto_barang) }}" alt="{{ $barang->nama_barang }}">
    </div>
@endsection

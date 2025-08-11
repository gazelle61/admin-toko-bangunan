@extends('layouts.admin')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Detail Barang</b></h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Foto Barang</th>
                            <td class="text-center">
                                @if ($barang->foto_barang)
                                    <img src="{{ Storage::url($barang->foto_barang) }}" alt="foto_barang" width="100" class="img-thumbnail">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori Barang</th>
                            <td>{{ $barang->kategori->nama_kategori }}</td>
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
                </div>
                <div class="card-footer">
                    <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Barang</b></h4>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('barang.create') }}" class="btn btn-primary" style="max-width: 180px; width:100%;"><i
                    class="fas fa-plus-circle"></i> Tambah Barang</a>

            <form method="GET" class="d-flex" style="max-width: 300px; width:100%;">
                <input type="text" name="search" class="form-control rounded-pill" placeholder="Cari data ..."
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="table-reponsive">
            <table class="table table-bordered text-center align-midle">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Foto Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if ($barang->foto_barang)
                                    <img src="{{ Storage::url($barang->foto_barang) }}" alt="foto_barang" width="100">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->ukuran }}</td>
                            <td>Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>{{ $barang->deskripsi }}</td>
                            <td class="text-center">
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $barangs->withQueryString()->links() }}
        </div>

    </div>
@endsection

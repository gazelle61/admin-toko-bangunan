@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Supplier</b></h4>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('supplier.create') }}" class="btn btn-primary" style="max-width: 180px; width:100%;"><i
                    class="fas fa-plus-circle"></i> Tambah Data</a>

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
                        <th>Kategori Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Barang Supplier</th>
                        <th>Kontak Supplier</th>
                        <th>Alamat Supplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $supplier->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $supplier->nama_supplier }}</td>
                            <td>{{ $supplier->barang_supplyan }}</td>
                            <td>{{ $supplier->kontak_supplier }}</td>
                            <td>{{ $supplier->alamat_supplier }}</td>
                            <td class="text-center">
                                <a href="{{ route('supplier.edit', $supplier->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data supplier.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $suppliers->withQueryString()->links() }}
        </div>

    </div>
@endsection

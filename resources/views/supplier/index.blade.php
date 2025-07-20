@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Daftar Supplier</h4>
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">+ Tambah Data</a>
    </div>

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari ..." value="{{ request('search') }}">
    </form>

  <div class="table-reponsive">
    <table class="table table-bordered table-stripped align-midle">
        <thead class="text-center">
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
                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
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

  {{-- <div class="mt-3">
    {{ $barang->links() }}
  </div> --}}
</div>

@endsection

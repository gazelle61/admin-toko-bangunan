@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Kategori</b></h4>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary" style="max-width: 180px; width:100%;"><i
                    class="fas fa-plus-circle"></i> Tambah Kategori</a>

            <form method="GET" class="d-flex" style="max-width: 300px; width:100%;">
                <input type="text" name="search" class="form-control rounded-pill" placeholder="Cari data ..."
                    value="{{ request('search') }}">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Foto Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td class="text-center">
                                @if ($kategori->foto_kategori)
                                    <img src="{{ Storage::url($kategori->foto_kategori) }}" alt="foto_kategori"
                                        width="100">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('kategori.edit', $kategori->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $kategoris->withQueryString()->links() }}
        </div>

    </div>
@endsection

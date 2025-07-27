@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Kategori</h4>
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                            class="form-control rounded-3 @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
                        @error('nama_kategori')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="fw-semibold">Foto Kategori</label>
                        <input type="file" name="foto_kategori"
                            class="form-control @error('foto_kategori') is-invalid @enderror">
                        @error('foto_kategori')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kategori.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        <hr>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

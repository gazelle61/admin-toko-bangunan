@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h4 class="mb-4 fw-bold">Tambah Kategori Baru</h4>
            <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control rounded-3 @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori') }}">
                    @error('nama_kategori')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="fw-semibold">Foto Kategori</label>
                    <input type="file" name="foto_kategori" class="form-control-file rounded-3  @error('foto_kategori') is-invalid @enderror">
                    @error('foto_kategori')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                    <hr>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

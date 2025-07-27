@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Barang</h4>
                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="fw-semibold">Foto Barang</label>
                        <input type="file" name="foto_barang"
                            class="form-control @error('foto_barang') is-invalid @enderror">
                        @error('foto_barang')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang"
                            class="form-control rounded-3 @error('nama_barang') is-invalid @enderror"
                            value="{{ old('nama_barang', $barang->nama_barang) }}">
                        @error('nama_barang')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kategori Barang</label>
                        <select name="kategori_id"
                            class="form-control rounded-3 @error('kategori_id') is-invalid @enderror">
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Ukuran Barang</label>
                        <input type="text" name="ukuran"
                            class="form-control rounded-3 @error('ukuran') is-invalid @enderror"
                            value="{{ old('ukuran', $barang->ukuran) }}">
                        @error('ukuran')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold">Harga</label>
                            <input type="number" name="harga"
                                class="form-control rounded-3 @error('harga') is-invalid @enderror"
                                value="{{ old('harga', $barang->harga) }}">
                            @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold">Stok</label>
                            <input type="number" name="stok"
                                class="form-control rounded-3 @error('stok') is-invalid @enderror"
                                value="{{ old('stok', $barang->stok) }}">
                            @error('stok')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-3 @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        <hr>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

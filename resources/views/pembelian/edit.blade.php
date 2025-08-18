@extends('layouts.admin')

@section('title', 'Edit Data')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Data Pembelian</h4>
                <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nota Pembelian --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nota Pembelian</label>
                        <input type="file" name="nota_pembelian"
                            class="form-control @error('nota_pembelian') is-invalid @enderror">
                        @error('nota_pembelian')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tanggal Transaksi --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Tanggal Transaksi</label>
                        <input type="date" name="tgl_transaksi"
                            class="form-control rounded-3 @error('tgl_transaksi') is-invalid @enderror"
                            value="{{ old('tgl_transaksi', $pembelian->tgl_transaksi) }}">
                        @error('tgl_transaksi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Supplier --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Pilih Supplier</label>
                        <select name="supplier_id"
                            class="form-control rounded-3 @error('supplier_id') is-invalid @enderror">
                            <option value="">--Pilih Supplier--</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}"
                                    {{ old('supplier_id', $pembelian->supplier_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Detail Barang --}}
                    <h5 class="fw-bold">Detail Barang</h5>
                    <div id="detail-wrapper">
                        <div class="border rounded p-3 mb-3 detail-item">
                            {{-- Kategori --}}
                            <div class="form-group mb-2">
                                <label class="fw-semibold">Kategori</label>
                                <select name="detail[0][kategori_id]" class="form-control rounded-3" required>
                                    <option value="">--Pilih Kategori--</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nama Barang --}}
                            <div class="form-group mb-2">
                                <label class="fw-semibold">Nama Barang</label>
                                <input type="text" name="detail[0][nama_barang]" class="form-control rounded-3" required>
                            </div>

                            {{-- Jumlah dan Harga Satuan --}}
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Jumlah</label>
                                    <input type="number" name="detail[0][jumlah]" class="form-control rounded-3" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Harga Satuan</label>
                                    <input type="number" name="detail[0][harga_satuan]" class="form-control rounded-3"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="button" class="btn btn-sm btn-outline-primary mb-4" id="tambah-detail">
                        <i class="fas fa-plus-circle"></i> Tambah Barang
                    </button>

                    {{-- Total Pengeluaran --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Total Pengeluaran</label>
                        <input type="number" name="harga"
                            class="form-control rounded-3 @error('harga') is-invalid @enderror"
                            value="{{ old('harga', $pembelian->harga) }}">
                        @error('harga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pembelian.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        <hr>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Tambah Detail --}}
    <script>
        let index = 1;
        const kategoriOptions = `{!! $kategori->map(fn($k) => "<option value='$k->id'>$k->nama_kategori</option>")->implode('') !!}`;

        document.getElementById('tambah-detail').addEventListener('click', function() {
            const html = `
        <div class="border rounded p-3 mb-3 detail-item">
            <div class="form-group mb-2">
                <label class="fw-semibold">Kategori</label>
                <select name="detail[${index}][kategori_id]" class="form-control rounded-3" required>
                    <option value="">--Pilih Kategori--</option>
                    ${kategoriOptions}
                </select>
            </div>

            <div class="form-group mb-2">
                <label class="fw-semibold">Nama Barang</label>
                <input type="text" name="detail[${index}][nama_barang]" class="form-control rounded-3" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-semibold">Jumlah</label>
                    <input type="number" name="detail[${index}][jumlah]" class="form-control rounded-3" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-semibold">Harga Satuan</label>
                    <input type="number" name="detail[${index}][harga_satuan]" class="form-control rounded-3" required>
                </div>
            </div>
        </div>`;
            document.getElementById('detail-wrapper').insertAdjacentHTML('beforeend', html);
            index++;
        });
    </script>
@endsection

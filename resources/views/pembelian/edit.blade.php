@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Data</h4>
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="fw-semibold">Bukti Transaksi</label>
                        <input type="file" name="bukti_transaksi"
                            class="form-control @error('bukti_transaksi') is-invalid @enderror">
                        @error('bukti_transaksi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Tanggal Transaksi</label>
                        <input type="date" name="tgl_transaksi"
                            class="form-control rounded-3 @error('tgl_transaksi') is-invalid @enderror"
                            value="{{ old('tgl_transaksi', $pembelian->tgl_transaksi) }}">
                        @error('tgl_transaksi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Supplier</label>
                        <input type="text" name="supplier_id"
                            class="form-control rounded-3 @error('supplier_id') is-invalid @enderror"
                            value="{{ old('supplier_id') }}">
                        @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kategori Supplier</label>
                        <select name="kategori_id"
                            class="form-control rounded-3 @error('kategori_id') is-invalid @enderror">
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kategori_id', $pembelian->kategori_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Barang yang di Supply</label>
                        <select name="supplier_id"
                            class="form-control rounded-3 @error('supplier_id') is-invalid @enderror">
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}"
                                    {{ old('supplier_id', $supplier->supplier_id) == $k->id ? 'selected' : '' }}>
                                    {{ $s->barang_supplyan }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Jumlah Pembelian</label>
                        <input type="number" name="jumlah_pembelian"
                            class="form-control rounded-3 @error('jumlah_pembelian') is-invalid @enderror"
                            value="{{ old('jumlah_pembelian', $pembelian->jumlah_pembelian) }}">
                        @error('jumlah_pembelian')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Total Pengeluaran</label>
                        <input type="number" name="harga"
                            class="form-control rounded-3 @error('harga') is-invalid @enderror"
                            value="{{ old('harga', $pembelian->harga) }}">
                        @error('harga')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                <hr>
                <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

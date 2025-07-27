@extends('layouts.admin')

@section('title', 'Tambah Data')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Tambah Data Baru</h4>
                <form action="{{ route('penjualan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                            value="{{ old('tgl_transaksi') }}">
                        @error('tgl_transaksi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kontak Pelanggan</label>
                        <input type="text" name="kontak_pelanggan"
                            class="form-control rounded-3 @error('kontak_pelanggan') is-invalid @enderror"
                            value="{{ old('kontak_pelanggan') }}">
                        @error('kontak_pelanggan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr>
                    <h5 class="fw-bold">Detail Barang</h5>
                    <div id="detail-wrapper">
                        <div class="border rounded p-3 mb-3 detail-item">
                            <div class="form-group mb-2">
                                <label class="fw-semibold">Barang</label>
                                <select name="detail[0][barang_id]" class="form-control rounded-3" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($barang as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label class="fw-semibold">Kategori</label>
                                <select name="detail[0][kategori_id]" class="form-control rounded-3" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

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

                    <button type="button" class="btn btn-sm btn-outline-primary mb-4" id="tambah-detail"><i
                            class="fas fa-plus-circle"></i> Tambah Barang</button>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Total Pemasukan</label>
                        <input type="number" name="total_pemasukan"
                            class="form-control rounded-3 @error('total_pemasukan') is-invalid @enderror"
                            value="{{ old('total_pemasukan') }}">
                        @error('total_pemasukan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('penjualan.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                        <hr>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let index = 1;
        const barangOptions = `{!! $barang->map(fn($b) => "<option value='$b->id'>$b->nama_barang</option>")->implode('') !!}`;
        const kategoriOptions = `{!! $kategori->map(fn($k) => "<option value='$k->id'>$k->nama_kategori</option>")->implode('') !!}`;

        document.getElementById('tambah-detail').addEventListener('click', function() {
            const html = `
            <div class="border rounded p-3 mb-3 detail-item">
                <div class="form-group mb-2">
                    <label class="fw-semibold">Barang</label>
                    <select name="detail[${index}][barang_id]" class="form-control rounded-3" required>
                        <option value="">-- Pilih Barang --</option>
                        ${barangOptions}
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label class="fw-semibold">Kategori</label>
                    <select name="detail[${index}][kategori_id]" class="form-control rounded-3" required>
                        <option value="">-- Pilih Kategori --</option>
                        ${kategoriOptions}
                    </select>
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

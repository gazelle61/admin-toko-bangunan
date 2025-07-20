@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h4 class="mb-4 fw-bold">Tambah Data Baru</h4>
            <form action="{{ route('penjualan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-4">
                    <label class="fw-semibold">Bukti Transaksi</label>
                    <input type="file" name="bukti_transaksi" class="form-control @error('bukti_transaksi') is-invalid @enderror">
                    @error('bukti_transaksi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" class="form-control rounded-3 @error('tgl_transaksi') is-invalid @enderror" value="{{ old('tgl_transaksi') }}">
                    @error('tgl_transaksi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Kontak Pelanggan (opsional)</label>
                    <input name="kontak_pelanggan" class="form-control rounded-3 @error('kontak_pelanggan') is-invalid @enderror" value="{{ old('kontak_pelanggan') }}">
                    @error('kontak_pelanggan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="fw-semibold mb-2">Detail Barang</label>
                    <table class="table table-bordered" id="barang-table">
                        <thead class="table-secondary">
                            <tr>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-success" id="addRow">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="detail[0][barang_id]" class="form-control">
                                        @foreach ($barang as $b)
                                            <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="detail[0][kategori_id]" class="form-control">
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="detail[0][barang_id]" class="form-control">
                                        @foreach ($barang as $b)
                                            <option value="{{ $b->harga }}">{{ $b->harga }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="detail[0][jumlah]" class="form-control" /></td>
                                <td><button type="button" class="btn btn-sm btn-danger removeRow">-</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Total Pemasukan</label>
                    <input type="number" name="total_pemasukan" class="form-control rounded-3 @error('total_pemasukan') is-invalid @enderror" value="{{ old('total_pemasukan') }}">
                    @error('total_pemasukan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let index = 1;

    document.getElementById('addRow').addEventListener('click', function () {
        const tableBody = document.querySelector('#barang-table tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <select name="detail[${index}][barang_id]" class="form-control">
                    @foreach ($barang as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="detail[${index}][kategori_id]" class="form-control">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="detail[${index}][harga_satuan]" class="form-control" /></td>
            <td><input type="number" name="detail[${index}][jumlah]" class="form-control" /></td>
            <td><button type="button" class="btn btn-sm btn-danger removeRow">-</button></td>
        `;

        tableBody.appendChild(newRow);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush

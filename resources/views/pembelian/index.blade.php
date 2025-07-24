@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Pembelian</b></h4>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary" style="max-width: 180px; width:100%;"><i
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
                        <th>Bukti Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Supplier</th>
                        <th>Kategori Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Pembelian</th>
                        <th>Total Pengeluaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelians as $pembelian)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if ($pembelian->bukti_transaksi)
                                    <img src="{{ Storage::url($pembelian->bukti_transaksi) }}" alt="bukti_transaksi"
                                        width="100">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $pembelian->tgl_transaksi }}</td>
                            <td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $pembelian->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $pembelian->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $pembelian->jumlah_pembelian }}</td>
                            <td>Rp{{ number_format($pembelian->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('pembelian.edit', $pembelian->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $pembelians->withQueryString()->links() }}
        </div>

    </div>
@endsection

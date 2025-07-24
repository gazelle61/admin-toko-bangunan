@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Data Penjualan</h4>
        </div>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary" style="max-width: 150px; width:100%;"><i
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
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Harga Barang</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pemasukan</th>
                        <th>Kontak Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                @if ($penjualan->bukti_transaksi)
                                    <img src="{{ Storage::url($penjualan->bukti_transaksi) }}" alt="bukti_transaksi"
                                        width="100">
                                    <span class="badge badge-success mt-1">Bukti valid</span>
                                @else
                                    <span class="badge badge-danger">Bukti tidak valid</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($penjualan->tgl_transaksi)->format('d F Y') }}</td>
                            <td>
                                @foreach ($penjualan->detail as $item)
                                    <div>{{ $item->barang->nama_barang ?? '-' }}</div>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($penjualan->detail as $item)
                                    <div>{{ $item->kategori->nama_kategori ?? '-' }}</div>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($penjualan->detail as $item)
                                    <div>{{ $item->jumlah ?? '-' }}</div>
                                @endforeach
                            </td>
                            <td>Rp{{ number_format($penjualan->total_pemasukan, 0, ',', '.') }}</td>
                            <td>{{ $penjualan->kontak_pelanggan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('penjualan.edit'), $penjualan->id }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('penjualan.show', $penjualan->id) }}"
                                    class="btn btn-sm btn-info">Detail</a>
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

        <div class="d-flex justify-content-end mt-3">
            {{ $penjualans->links() }}
        </div>

    </div>
@endsection

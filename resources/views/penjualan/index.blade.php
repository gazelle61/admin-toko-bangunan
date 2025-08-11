@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Penjualan</b></h4>
        </div>

        @if (session('success'))
            <div class="alert aler-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary" style="max-width: 220px; width:100%;"><i
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
                        <th>Tanggal Transaksi</th>
                        <th>Total Pemasukan</th>
                        <th>Pelanggan</th>
                        <th>Sumber Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration + ($penjualans->currentPage() - 1) * $penjualans->perPage() }}</td>
                            <td>{{ $penjualan->tgl_transaksi }}</td>
                            <td>Rp{{ number_format($penjualan->total_pemasukan, 0, ',', '.') }}</td>
                            <td>{{ $penjualan->kontak_pelanggan ?? '-' }}</td>
                            <td>{{ ucfirst($penjualan->source) }}</td>
                            <td class="text-center">
                                <a href="{{ route('penjualan.show', $penjualan->id) }}"
                                    class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('penjualan.edit', $penjualan->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
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
            {{ $penjualans->withQueryString()->links() }}
        </div>

    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Data Penjualan</b></h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <form method="GET" class="d-flex" style="max-width: 300px; width:100%;">
                <input type="text" name="search" class="form-control rounded-pill me-2" placeholder="Cari data ..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-pill">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
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
                            <td>
                                {{ $loop->iteration + ($penjualans->currentPage() - 1) * $penjualans->perPage() }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($penjualan->tgl_transaksi)->translatedFormat('d F Y') }}</td>
                            <td>Rp{{ number_format($penjualan->total_pemasukan, 0, ',', '.') }}</td>
                            <td>{{ $penjualan->nama_penerima ?? '-' }}</td>
                            <td>{{ Str::title($penjualan->source) }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', $penjualan->id) }}"
                                    class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
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

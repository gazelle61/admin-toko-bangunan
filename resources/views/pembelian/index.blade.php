@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-fleax justify-content-between mb-3">
        <h4>Data Pembelian</h4>
        {{-- <a href="{{ route('pembelian.create') }}" class="btn btn-primary">+ Tambah Data</a> --}}
    </div>

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Carig ..." value="{{ request('search') }}">
    </form>

  <div class="table-reponsive">
    <table class="table table-bordered table-stripped align-midle">
        <thead class="text-center">
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
                        <img src="{{ Storage::url($pembelian->bukti_transaksi) }}" alt="bukti_transaksi" width="150">
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
                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                        <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
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

  {{-- <div class="mt-3">
    {{ $barang->links() }}
  </div> --}}
</div>

@endsection

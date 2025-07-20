@extends('layouts.admin')

@section('content')
<section class="content p-3">
    <div class="container-fluid">

        <div class="row mb-3">
            <div class="col-md-6">
                <h4><strong>Kasir</strong></h4>
            </div>
            <div class="col-md-6 text-right">
                @if(session('last_invoice'))
                    <h5>Invoice <strong>#{{ session('last_invoice') }}</strong></h5>
                    <h4 class="text-success text-success">Rp{{ number_format(session('last_total')) }}</h4>
                @else
                    <h5>Invoice <strong>#TBNT{{ date('YmdHis') }}</strong></h5>
                    <h4 class="text-success">Rp{{ number_format($totalBelanja) }}</h4>
                @endif
            </div>
        </div>

        <div class="card p-3">
            {{-- Form Input --}}
            <form method="POST" action="{{ route('kasir.tambahKeranjang') }}">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Pembeli</label>
                        <input type="text" name="pembeli" class="form-control" placeholder="08xxxxxxxx">
                    </div>
                    <div class="col-md-3">
                        <label>Produk</label>
                        <div class="input-group">
                            <select name="barang_id" class="form-control">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($barangs as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_barang }} - Rp{{ number_format($item->harga_satuan) }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah_beli" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary btn-block"><i class="fas fa-cart-plus"></i></button>
                    </div>
                </div>
            </form>

            <hr>

            {{-- Tabel Keranjang --}}
            <div class="table responsive">
                <table class="table table-bordered mt-3">
                    <thead class="thead-primary">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keranjang as $index => $barang )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang['barang_id'] }}</td>
                            <td>{{ $barang['nama_barang'] }}</td>
                            <td>Rp{{ number_format($barang['harga_satuan']) }}</td>
                            <td>{{ $barang['jumlah_beli'] }}</td>
                            <td>Rp{{ number_format($barang['total_item']) }}</td>
                            <td>
                                <form action="{{ route('kasir.hapusDariKeranjang', $barang['barang_id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            {{-- Ringkasan Pembayaran --}}
            <form action="{{ route('kasir.prosesTransaksi') }}" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label>Total Belanja</label>
                        @php
                            $totalBelanja = collect($keranjang)->sum('total_item');
                        @endphp
                        <input type="hidden" name="total" value="{{ $totalBelanja }}">
                        <p class="form-control-plaintext">Rp{{ number_format($totalBelanja, 0, ',', '.') }}</p>

                    </div>
                    <div class="col-md-4">
                        <label>Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        <div>
                            <button type="button" class="btn btn-danger mr-2"><i class="fas fa-times"></i> Batalkan</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Proses</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection

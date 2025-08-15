@extends('layouts.admin')

@section('content')
    <section class="content p-3">
        <div class="container-fluid">

            {{-- Header Kasir --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4><strong>Kasir</strong></h4>
                <div class="text-right">
                    @if (session('last_invoice'))
                        <h5>Invoice <strong>#{{ session('last_invoice') }}</strong></h5>
                        <h4 class="text-success">Rp{{ number_format(session('last_total')) }}</h4>
                    @else
                        <h5>Invoice <strong>#TBNT{{ date('YmdHis') }}</strong></h5>
                        <h4 class="text-success">Rp{{ number_format($totalBelanja) }}</h4>
                    @endif
                </div>
            </div>

            <div class="row">
                {{-- Form Input Barang --}}
                <div class="col-md-8">
                    <div class="card p-3 mb-3">
                        <h6><strong>Tambah Barang</strong></h6>
                        <form id="formTambahKeranjang" method="POST" action="{{ route('kasir.tambahKeranjang') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-5">
                                    <label>Barang</label>
                                    <select id="barang_id" name="barang_id" class="form-control select2">
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}"
                                                {{ $barang->stok == 0 ? 'disabled' : '' }}>
                                                {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Jumlah</label>
                                    <input type="number" id="jumlah_beli" name="jumlah_beli" class="form-control"
                                        min="1" value="1">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button class="btn btn-primary btn-block"><i class="fas fa-cart-plus"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Keranjang --}}
                    <div class="card p-3">
                        <h6><strong>Keranjang Belanja</strong></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Barang</th>
                                        <th>Barang</th>
                                        <th>Harga /pcs</th>
                                        <th>Jumlah</th>
                                        <th>Total Item</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($keranjang as $index => $barang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $barang['barang_id'] }}</td>
                                            <td>{{ $barang['nama_barang'] }}</td>
                                            <td>Rp{{ number_format($barang['harga_satuan']) }}</td>
                                            <td>{{ $barang['jumlah_beli'] }}</td>
                                            <td>Rp{{ number_format($barang['total_item']) }}</td>
                                            <td class="text-center">
                                                <form class="form-hapus-keranjang"
                                                    action="{{ route('kasir.hapusDariKeranjang', $barang['barang_id']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Keranjang kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if (count($keranjang) > 0)
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Total</th>
                                            <th colspan="2">Rp{{ number_format($totalBelanja) }}</th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Form Pembayaran --}}
                <div class="col-md-4">
                    <div class="card p-3">
                        <h6><strong>Pembayaran</strong></h6>
                        <form action="{{ route('kasir.prosesTransaksi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="total" value="{{ $totalBelanja }}">

                            <div class="form-group">
                                <label>Total Belanja</label>
                                <p class="form-control-plaintext h5 text-primary">
                                    Rp{{ number_format($totalBelanja, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Bayar</label>
                                <input type="text" name="jumlah_bayar_display" id="jumlah_bayar_display"
                                    class="form-control" required>
                                <input type="hidden" name="jumlah_bayar" id="jumlah_bayar">
                            </div>
                            <div class="form-group">
                                <label>Pembeli</label>
                                <input type="text" name="pembeli" class="form-control" placeholder="nama/nomor pembeli">
                            </div>
                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg btn-block">
                                <i class="fas fa-check"></i> Proses
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.10.5"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfirmasi hapus item
            document.querySelectorAll('.form-hapus-keranjang').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin hapus barang?',
                        text: "Barang akan dihapus dari keranjang.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Validasi jumlah beli tidak melebihi stok
            document.getElementById('formTambahKeranjang').addEventListener('submit', function(e) {
                let selectBarang = document.getElementById('barang_id');
                let selectedOption = selectBarang.options[selectBarang.selectedIndex];
                let stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
                let jumlah = parseInt(document.getElementById('jumlah_beli').value) || 0;

                if (jumlah > stok) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Jumlah Melebihi Stok',
                        text: `Stok tersedia hanya ${stok}.`,
                        confirmButtonColor: '#d33'
                    });
                }
            });

            // Format input bayar jadi Rp
            const bayarInput = new AutoNumeric('#jumlah_bayar_display', {
                currencySymbol: 'Rp ',
                decimalCharacter: ',',
                digitGroupSeparator: '.',
                unformatOnSubmit: true
            });

            // Set hidden input sebelum submit pembayaran
            document.querySelector('form[action="{{ route('kasir.prosesTransaksi') }}"]').addEventListener(
                'submit',
                function() {
                    document.getElementById('jumlah_bayar').value = bayarInput.getNumber();
                });
        });
    </script>
@endpush

@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Data</h4>
                <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST" enctype="multipart/form-data">
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

                    {{-- PILIH SUPPLIER --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Pilih Supplier</label>
                        <select name="supplier_id" id="supplierSelect"
                            class="form-control rounded-3 @error('supplier_id') is-invalid @enderror">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}" data-barang="{{ $s->barang_supplyan }}"
                                    {{ old('supplier_id', $pembelian->supplier_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PILIH BARANG --}}
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Barang dari Supplier</label>
                        <select name="nama_barang" id="barangSelect"
                            class="form-control rounded-3 @error('nama_barang') is-invalid @enderror">
                            <option value="">-- Pilih Barang --</option>
                        </select>
                        @error('nama_barang')
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
                <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                <hr>
                <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const supplierSelect = document.getElementById("supplierSelect");
            const barangSelect = document.getElementById("barangSelect");
            const oldSupplier = "{{ old('supplier_id', $pembelian->supplier_id) }}";
            const oldBarang = "{{ old('nama_barang', $pembelian->nama_barang) }}";

            supplierSelect.addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];
                const barangData = selected.getAttribute("data-barang");

                barangSelect.innerHTML = '<option value="">-- Pilih Barang --</option>';

                if (barangData) {
                    let barangList;
                    try {
                        barangList = JSON.parse(barangData);
                    } catch (e) {
                        barangList = barangData.split(',');
                    }

                    barangList.forEach(barang => {
                        const option = document.createElement("option");
                        option.value = barang.trim();
                        option.text = barang.trim();
                        if (barang.trim() === oldBarang) {
                            option.selected = true;
                        }
                        barangSelect.appendChild(option);
                    });
                }
            });

            if (oldSupplier) {
                supplierSelect.value = oldSupplier;
                supplierSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush

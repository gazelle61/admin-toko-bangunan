@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <h4 class="mb-4 fw-bold">Edit Data</h4>
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kategori Supplier</label>
                        <select name="kategori_id" class="form-control rounded-3 @error('kategori_id') is-invalid @enderror">
                            @foreach ($kategori as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kategori_id', $supplier->kategori_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Supplier</label>
                        <select name="nama_supplier" id="nama_supplier"
                            class="form-control rounded-3 @error('nama_supplier') is-invalid @enderror">
                            {{-- Tampilkan data lama yang sedang diedit --}}
                            <option value="{{ $supplier->nama_supplier }}" selected>
                                {{ $supplier->nama_supplier }} (Saat ini)
                            </option>

                            {{-- Loop semua supplier unik --}}
                            @foreach ($allSuppliers as $s)
                                @if ($s->nama_supplier != $supplier->nama_supplier)
                                    <option value="{{ $s->nama_supplier }}">{{ $s->nama_supplier }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('nama_supplier')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Barang dari Supplier</label>
                        <input type="text" name="barang_supplyan"
                            class="form-control rounded-3 @error('barang_supplyan') is-invalid @enderror"
                            value="{{ old('barang_supplyan', $supplier->barang_supplyan) }}">
                        @error('barang_supplyan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Kontak Supplier</label>
                        <input type="number" name="kontak_supplier"
                            class="form-control rounded-3 @error('kontak_supplier') is-invalid @enderror"
                            value="{{ old('kontak_supplier', $supplier->kontak_supplier) }}">
                        @error('kontak_supplier')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="fw-semibold">Alamat Supplier</label>
                        <textarea name="alamat_supplier" class="form-control rounded-3 @error('alamat_supplier') is-invalid @enderror">{{ old('alamat_supplier', $supplier->alamat_supplier) }}</textarea>
                        @error('alamat_supplier')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('supplier.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
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
        $(document).ready(function() {
            $('#nama_supplier').select2({
                tags: true, // bisa input baru
                placeholder: "Pilih atau ketik nama supplier",
                allowClear: true
            });
        });
    </script>
@endpush

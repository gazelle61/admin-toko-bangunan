@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Daftar FAQ</b></h4>
        </div>

        {{-- <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('barang.create') }}" class="btn btn-primary" style="max-width: 180px; width:100%;"><i class="fas fa-plus-circle"></i> Tambah Barang</a>

        <form method="GET" class="d-flex" style="max-width: 300px; width:100%;">
            <input type="text" name="search" class="form-control rounded-pill" placeholder="Cari data ..." value="{{ request('search') }}">
        </form>
    </div> --}}

        <div class="table-reponsive">
            <table class="table table-bordered text-center align-midle">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pertanyaan</th>
                        {{-- <th>Jawaban</th>
                <th>Dikirim Pada</th>
                <th>Tampilkan ke Publik</th>
                <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faqs as $faq)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $faq->nama }}</td>
                            <td>{{ $faq->email }}</td>
                            <td>{{ $faq->pertanyaan }}</td>
                            {{-- <td>{{ $faq->jawaban }}</td>
                <td>{{ $faq->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.faq.update', $faq->id) }}">
                        @csrf
                        @method('PUT')
                        <textarea name="jawaban" class="form-control" rows="3">{{ $faq->jawaban }}</textarea>

                        <label>
                            <input type="checkbox" name="is_public" value="1" {{ $faq->is_public ? 'checked' : '' }}> Tampilkan ke publik
                        </label>

                        <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan</button>
                    </form>
                </td> --}}
                            {{-- <td class="text-center">
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                </td> --}}
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
            {{ $faqs->withQueryString()->links() }}
        </div>

    </div>
@endsection

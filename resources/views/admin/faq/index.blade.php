@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><b>Daftar FAQ</b></h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-midle">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pertanyaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($faqs as $faq)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $faq->nama }}</td>
                            <td>
                                {{ $faq->email }}
                                <button class="btn btn-sm btn-outline-primary ms-2"
                                    onclick="copyToClipboard('{{ e($faq->email) }}')">
                                    Copy
                                </button>
                            </td>
                            <td>
                                {{ $faq->pertanyaan }}
                                <button class="btn btn-sm btn-outline-primary ms-2"
                                    onclick="copyToClipboard('{{ e($faq->pertanyaan) }}')">
                                    Copy
                                </button>
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
            {{ $faqs->withQueryString()->links() }}
        </div>

    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Teks berhasil disalin!');
            }, function() {
                alert('Gagal menyalin teks!');
            });
        }
    </script>
@endsection

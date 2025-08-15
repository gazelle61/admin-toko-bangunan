@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center">
        {{-- BOX: Jumlah Kategori --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    {{-- Tampilkan jumlah kategori --}}
                    <h3>{{ $kategoriCount }}</h3>
                    <p>Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                {{-- Link ke halaman kategori --}}
                <a href="{{ route('kategori.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- BOX: Jumlah Barang --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $barangCount }}</h3>
                    <p>Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('barang.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- BOX: Jumlah Supplier --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $supplierCount }}</h3>
                    <p>Supplier</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('supplier.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Grafik Penjualan --}}
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Grafik Penjualan</b></h3>

                {{-- Dropdown filter range (minggu, bulan, tahun) --}}
                <div class="d-flex justify-content-end mb-3">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <select name="range" class="form-select" onchange="this.form.submit()" style="width: 200px">
                            <option value="minggu" {{ request('range') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                            <option value="bulan" {{ request('range') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                            <option value="tahun" {{ request('range') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="card-body">
                {{-- Kanvas untuk Chart.js --}}
                <canvas id="salesChart" width="835" height="300"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Load Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');

        // Inisialisasi Chart.js
        const salesChart = new Chart(ctx, {
            type: 'line', // jenis grafik
            data: {
                labels: @json($labels), // label dari controller
                datasets: [{
                    label: 'Penjualan', // nama legend
                    data: @json($totals), // data penjualan
                    borderColor: 'rgba(60,141,188,1)', // warna garis
                    backgroundColor: 'rgba(60,141,188,0.2)', // warna area bawah garis
                    tension: 0.4 // kelengkungan garis
                }]
            },
            options: {
                responsive: true, // agar menyesuaikan layar
                plugins: {
                    legend: {
                        display: true // tampilkan legend
                    },
                    tooltip: {
                        enabled: true // tooltip aktif
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // sumbu Y mulai dari 0
                    }
                }
            }
        });
    </script>
@endpush

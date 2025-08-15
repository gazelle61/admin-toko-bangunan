<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set locale untuk bahasa Indonesia (untuk format tanggal & nama bulan/hari)
        setlocale(LC_TIME, 'id_ID.UTF-8');
        Carbon::setLocale('id');

        // Ambil range waktu dari request, default 'minggu'
        $range = $request->get('range', 'minggu');
        $now = Carbon::today();

        // Tentukan awal & akhir periode berdasarkan pilihan range
        if ($range === 'minggu') {
            // Minggu terakhir (7 hari terakhir termasuk hari ini)
            $start = $now->copy()->subDays(6);
            $end = $now;
            $groupFormat = 'Y-m-d'; // format grouping per hari
        } elseif ($range === 'bulan') {
            // Awal bulan sampai hari ini
            $start = $now->copy()->startOfMonth();
            $end = $now;
            $groupFormat = 'Y-m-d';
        } elseif ($range === 'tahun') {
            // Awal tahun sampai hari ini
            $start = $now->copy()->startOfYear();
            $end = $now;
            $groupFormat = 'Y-m';
        } else {
            // Custom date range (kalau nanti ada fitur pilih tanggal sendiri)
            $start = Carbon::parse($request->get('start'));
            $end = Carbon::parse($request->get('end'));
            $groupFormat = 'Y-m-d';
        }

        // Format tanggal untuk MySQL DATE_FORMAT
        if ($groupFormat === 'Y-m-d') {
            $dateFormat = '%Y-%m-%d'; // format tanggal lengkap
        } else {
            $dateFormat = '%Y-%m'; // format tahun-bulan
        }

        // Ambil total pemasukan per grup (per hari / per bulan)
        $penjualan = Penjualan::selectRaw("
                DATE_FORMAT(tgl_transaksi, '{$dateFormat}') as grup,
                SUM(total_pemasukan) as total
            ")
            ->whereBetween('tgl_transaksi', [$start, $end]) // filter sesuai range
            ->groupBy('grup') // group by hasil format tanggal
            ->orderBy('grup') // urutkan dari awal ke akhir
            ->pluck('total', 'grup'); // hasil: ['2025-08-01' => 12000, ...]

        // Siapkan array untuk label chart & data total penjualan
        $labels = [];
        $totals = [];

        // Jika grouping per hari
        if ($groupFormat === 'Y-m-d') {
            foreach (CarbonPeriod::create($start, $end) as $date) {
                if ($range === 'bulan') {
                    // Untuk range 'bulan' → label berupa tanggal + bulan (misal 01 Agu)
                    $labels[] = $date->translatedFormat('d M');
                } else {
                    // Untuk range 'minggu' atau custom → label berupa nama hari
                    $labels[] = $date->translatedFormat('l');
                }

                // Isi data total, jika tidak ada data pakai 0
                $totals[] = $penjualan[$date->format('Y-m-d')] ?? 0;
            }
        }
        // Jika grouping per bulan
        elseif ($groupFormat === 'Y-m') {
            for ($month = $start->month; $month <= $end->month; $month++) {
                // Label nama bulan
                $labels[] = Carbon::create()->month($month)->translatedFormat('F');

                // Ambil key untuk array $penjualan
                $key = $start->copy()->month($month)->format('Y-m');

                // Isi data total
                $totals[] = $penjualan[$key] ?? 0;
            }
        }

        // Hitung jumlah kategori, barang, dan supplier
        $kategoriCount = Kategori::count();
        $barangCount = Barang::count();
        $supplierCount = Supplier::count();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'kategoriCount',
            'barangCount',
            'supplierCount',
            'labels',
            'totals'
        ));
    }
}

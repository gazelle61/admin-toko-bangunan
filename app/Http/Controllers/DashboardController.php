<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Supplier;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        setlocale(LC_TIME, 'id_ID.UTF-8');
        Carbon::setLocale('id');

        $range = $request->get('range', 'minggu');
        $now = Carbon::today();

        if ($range === 'minggu') {
            $start = $now->copy()->subDays(6);
            $end = $now;
            $groupFormat = 'Y-m-d';
        } elseif ($range === 'bulan') {
            $start = $now->copy()->startOfMonth();
            $end = $now;
            $groupFormat = 'Y-m-d';
        } elseif ($range === 'tahun') {
            $start = $now->copy()->startOfYear();
            $end = $now;
            $groupFormat = 'Y-m';
        } else {
            $start = Carbon::parse($request->get('start'));
            $end = Carbon::parse($request->get('end'));
            $groupFormat = 'Y-m-d';
        }

        if ($groupFormat === 'Y-m-d') {
            $dateFormat = '%Y-%m-%d';
        } else {
            $dateFormat = '%Y-%m';
        }

        $penjualan = Penjualan::selectRaw("DATE_FORMAT(tgl_transaksi, '{$dateFormat}') as grup, SUM(total_pemasukan) as total")
            ->whereBetween('tgl_transaksi', [$start, $end])
            ->groupBy('grup')
            ->orderBy('grup')
            ->pluck('total', 'grup');

        $labels = [];
        $totals = [];

        if ($groupFormat === 'Y-m-d') {
            foreach (CarbonPeriod::create($start, $end) as $date) {
                $labels[] = $date->translatedFormat('l'); // Nama hari
                $totals[] = $penjualan[$date->format('Y-m-d')] ?? 0;
            }
        } elseif ($groupFormat === 'Y-m') {
            for ($month = $start->month; $month <= $end->month; $month++) {
                $labels[] = Carbon::create()->month($month)->translatedFormat('F'); // Nama bulan
                $key = $start->copy()->month($month)->format('Y-m');
                $totals[] = $penjualan[$key] ?? 0;
            }
        }

        $kategoriCount = Kategori::count();
        $barangCount = Barang::count();
        $supplierCount = Supplier::count();

        return view('admin.dashboard', compact(
            'kategoriCount',
            'barangCount',
            'supplierCount',
            'labels',
            'totals'
        ));
    }
}

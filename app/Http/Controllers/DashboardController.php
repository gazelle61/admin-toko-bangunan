<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Penjualan; //ganti dengan model 'transaksi'
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', 'minggu');
        $now = Carbon::now();

        $labels = [];
        $totals = [];

        if ($range === 'minggu'){
            $penjualan = Penjualan::selectRaw('DAYNAME(created_at) as hari, SUM(total_pemasukan) as total')
                ->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()])
                ->groupBy('hari')
                ->get();

            $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            foreach ($labels as $day) {
                $totals[] = $penjualan->firstWhere('hari', $day)?->total ?? 0;
            }
        } elseif ($range === 'bulan'){
            $penjualan = Penjualan::selectRaw('DAY(created_at) as hari, SUM(total_pemasukan) as total')
                ->whereMonth('created_at', $now->month)
                ->groupBy('hari')
                ->get();

            $labels = range(1, $now->daysInMonth);
            foreach ($labels as $day) {
                $totals[] = $penjualan->firstWhere('hari', $day)?->total ?? 0;
            }
        } elseif ($range === 'tahun'){
            $penjualan = Penjualan::selectRaw('MONTHNAME(created_at) as bulan, SUM(total_pemasukan) as total')
                ->whereYear('created_at', $now->year)
                ->groupBy('bulan')
                ->get();

            $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            foreach ($labels as $bulan) {
                $totals[] = $penjualan->firstWhere('bulan', $bulan)?->total ?? 0;
            }
        }

        $kategoriCount = Kategori::count();
        $barangCount = Barang::count();
        $supplierCount = Supplier::count();

        return view('admin.dashboard', compact(
            'kategoriCount', 'barangCount','supplierCount',
            'labels', 'totals'
        ));
    }
}

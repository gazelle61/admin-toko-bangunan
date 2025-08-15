<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    public function topProducts()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $topProducts = DB::table('penjualan_detail')
            ->join('barang', 'penjualan_detail.barang_id', '=', 'barang.id')
            ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
            ->whereBetween('penjualan.tgl_transaksi', [$startOfWeek, $endOfWeek])
            ->select(
                'barang.id',
                'barang.nama_barang',
                DB::raw('SUM(penjualan_detail.jumlah) as jumlah')
            )
            ->groupBy('barang.id', 'barang.nama_barang')
            ->orderByDesc('jumlah')
            ->limit(6)
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Top products this week fetched successfully.',
            'data'    => $topProducts
        ]);
    }
}

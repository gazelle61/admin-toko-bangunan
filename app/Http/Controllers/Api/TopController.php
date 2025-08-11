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

        $topProducts = DB::table('penjualan_details')
            ->join('barangs', 'penjualan_details.barang_id', '=', 'barangs.id')
            ->join('penjualans', 'penjualan_details.penjualan_id', '=', 'penjualans.id')
            ->whereBetween('penjualans.tgl_transaksi', [$startOfWeek, $endOfWeek])
            ->select(
                'barangs.id',
                'barangs.nama_barang',
                DB::raw('SUM(penjualan_details.qty) as total_qty')
            )
            ->groupBy('barangs.id', 'barangs.nama_barang')
            ->orderByDesc('total_qty')
            ->limit(6)
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Top products this week fetched successfully.',
            'data'    => $topProducts
        ]);
    }
}

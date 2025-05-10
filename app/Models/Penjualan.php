<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'barang_id',
        'tgl_transaksi',
        'kategori_id',
        'total_pemasukan',
        'jumlah_terjual',
        'kontak_pelanggan',
        'bukti_transaksi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

}

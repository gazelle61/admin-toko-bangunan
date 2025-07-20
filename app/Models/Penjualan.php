<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $with = ['detail.barang', 'detail.kategori'];

    protected $fillable = [
        'users_id',
        'tgl_transaksi',
        'total_pemasukan',
        'kontak_pelanggan',
        'bukti_transaksi',
        'source'
    ];

    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}

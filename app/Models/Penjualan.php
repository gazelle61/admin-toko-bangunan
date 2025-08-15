<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $with = ['details.barang', 'details.kategori'];

    protected $fillable = [
        'transactions_id', //null
        'users_id', //null
        'tgl_transaksi',
        'total_pemasukan',
        'kontak_pelanggan', //varchar 15, null
        'bukti_transaksi',
        'source'
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }
}

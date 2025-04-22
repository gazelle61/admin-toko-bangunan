<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'supplier_id',
        'tgl_transaksi',
        'kategori_id',
        'barang_id',
        'jumlah_pembelian',
        'harga',
        'bukti_transaksi',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

}

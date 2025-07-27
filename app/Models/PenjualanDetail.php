<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'kategori_id',
        'jumlah',
        'harga_satuan',
        // itu harga_satuan artinya = total_belanja
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

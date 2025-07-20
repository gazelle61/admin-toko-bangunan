<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKasir extends Model
{
    use HasFactory;

    protected $table = 'detail_kasir';

    protected $fillable = [
        'kasir_id',
        'barang_id',
        'harga_satuan',
        'jumlah_beli',
        'total_item'
    ];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

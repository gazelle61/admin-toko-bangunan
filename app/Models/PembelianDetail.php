<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';

    protected $fillable = [
        'pembelian_id',
        'kategori_id',
        'nama_barang',
        'jumlah',
        'harga_satuan',
    ];

    // relasi ke pembelian
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    // relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

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
        // 'kategori_id',
        // 'nama_barang', //null
        // 'jumlah_pembelian',
        'harga',
        'nota_pembelian', //null
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'foto_barang', //string, null
        'nama_barang',
        'ukuran',
        'kategori_id',
        'harga', //decimal 15,2
        'stok',
        'deskripsi' //notnull
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function transactions_items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function detail_kasir()
    {
        return $this->hasMany(DetailKasir::class);
    }

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}

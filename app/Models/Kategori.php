<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'foto_kategori' //null
    ];

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}

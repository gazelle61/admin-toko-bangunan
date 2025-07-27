<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier',
        'kategori_id',
        'barang_supplyan',
        'kontak_supplier',
        'alamat_supplier',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}

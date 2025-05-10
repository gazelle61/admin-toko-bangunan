<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'ukuran',
        'kategori_id',
        'harga',
        'stok',
        'deskripsi',
        'foto_barang'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

}

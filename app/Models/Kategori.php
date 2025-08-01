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
        'foto_kategori'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }
}

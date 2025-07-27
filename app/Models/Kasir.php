<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $table = 'kasir';

    protected $fillable = [
        'tgl_transaksi',
        'pembeli',
        'invoice_kode',
        'total_belanja',
        'jumlah_bayar',
        'jumlah_kembali',
        'catatan'
    ];

    public function details()
    {
        return $this->hasMany(DetailKasir::class);
    }
}

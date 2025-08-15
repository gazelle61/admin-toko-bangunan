<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $table = 'kasir';

    protected $fillable = [
        'tgl_transaksi', //datetime
        'pembeli', //null
        'invoice_kode',
        'total_belanja', //integer
        'jumlah_bayar', //integer
        'jumlah_kembali', //integer
        'catatan'
    ];

    public function details()
    {
        return $this->hasMany(DetailKasir::class);
    }
}

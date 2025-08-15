<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'users_id',
        'nama_penerima',
        'no_telepon',
        'alamat_pengiriman',
        'total_harga', //decimal 15,2
        'ongkir', //decimal 15,2
        'metode_pembayaran',
        'status_transactions', //null
        'bukti_transaksi',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transactions_id');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}

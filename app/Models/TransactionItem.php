<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transactions_items';

    protected $fillable = [
        'transactions_id',
        'barang_id',
        'quantity',
        'harga_satuan', //decimal 15,2
        'total_harga', //decimal 15,2
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

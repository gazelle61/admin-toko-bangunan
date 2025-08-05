<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transactions_items';

    protected $fillable = [
        'transaction_id',
        'barang_id',
        'quantity',
        'harga_satuan',
        'total_harga',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

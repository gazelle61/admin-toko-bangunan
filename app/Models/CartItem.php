<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'users_id',
        'barang_id',
        'quantity',
        'harga_satuan', //decimal 15,2
        'total_harga', //decimal 15,2
        'status_cart', //enum (active, checked_out, abandoned) null
    ];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

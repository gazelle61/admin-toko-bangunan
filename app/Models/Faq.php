<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';

    protected $fillable = [
        'user_id',
        'tanya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

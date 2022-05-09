<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requested extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'identify_numb',
        'buy_coin_1',
        'price_1',
        'buy_coin_2',
        'price_2',
        'buy_coin_3',
        'price_3',
        'created_at',
        'updated_at',
    ];
    protected $table    = 'requested';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
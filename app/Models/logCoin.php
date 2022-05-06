<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logCoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'coin_numb',
        'nap_coin_time',
    ];
    protected $table    = 'nap_coin_log';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
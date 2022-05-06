<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logKC extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kc_numb',
        'mua_kc_time',
    ];
    protected $table    = 'mua_kc_log';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
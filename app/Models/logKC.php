<?php

namespace App\Models;

use Carbon\Carbon;
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
    // // convert Y-m-d to d-m-Y when get dob Attribute
    // public function getTimeAttribute($value)
    // {
    //     return Carbon::createFromFormat('Y-m-d', $value)
    //         ->format('d-m');
    // }
}
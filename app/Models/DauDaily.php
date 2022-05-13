<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DauDaily extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_login',
        'date',
    ];
    protected $table    = 'dau_daily';
    public $timestamps  = false;
    
}

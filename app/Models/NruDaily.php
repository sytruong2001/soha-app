<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NruDaily extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_register',
        'date',
    ];
    protected $table    = 'nru_daily';
    public $timestamps  = false;
    
}

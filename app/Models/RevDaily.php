<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevDaily extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_kc',
        'date',
    ];
    protected $table    = 'rev_daily';
    public $timestamps  = false;
    
}
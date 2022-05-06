<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    use HasFactory;
    protected $fillable = [
        'locked_id',
        'message'
    ];
    protected $table    = 'locked';
    public $timestamps  = false;
}

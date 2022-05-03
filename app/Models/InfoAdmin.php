<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoAdmin extends Model
{
    use HasFactory;
    protected $table    = 'info_admin';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

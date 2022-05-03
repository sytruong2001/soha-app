<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KC extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kc_numb',
    ];
    protected $table    = 'info_kc';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_number',
        'user_id',
        'coin'
    ];
    protected $table    = 'info_user';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

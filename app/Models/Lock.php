<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    use HasFactory;
    protected $fillable = [
        'locked_id',
        'message',
        'locked_by',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $table    = 'locked';
    public function user()
    {
        return $this->belongsTo(User::class, 'locked_id');
    }
    public function locker()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }
}
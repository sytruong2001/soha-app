<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\KC;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function info_user()
    {
        return $this->hasOne(InfoUser::class);
    }

    public function info_admin()
    {
        return $this->hasOne(InfoAdmin::class);
    }
    public function info_kc()
    {
        return $this->hasOne(KC::class);
    }
    public function loginLog()
    {
        return $this->hasMany(loginLog::class);
    }
    public function logKc()
    {
        return $this->hasMany(logKC::class);
    }
    public function logCoin()
    {
        return $this->hasMany(logCoin::class);
    }
}
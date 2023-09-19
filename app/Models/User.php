<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "users";

    function department()
    {
        return $this->belongsTo(Department::class, "departement_id", "id");
    }

    function bon()
    {
        return $this->hasMany(Bon::class, "users_id", "id");
    }

    function detailbon()
    {
        return $this->hasMany(DetailBon::class, "users_id", "id");
    }

    function acc()
    {
        return $this->hasMany(Acc::class, "users_id", "id");
    }

    function acclaporan()
    {
        return $this->hasMany(AccLaporan::class, "users_id", "id");
    }

    function accreimburse()
    {
        return $this->hasMany(AccReimburse::class, "users_id", "id");
    }

    function laporan()
    {
        return $this->hasMany(Laporan::class, "users_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "users_id", "id");
    }

    function detailreimburse()
    {
        return $this->hasMany(DetailReimburse::class, "users_id", "id");
    }



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
}

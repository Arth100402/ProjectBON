<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }

    function acclaporan()
    {
        return $this->hasMany(AccLaporan::class, "laporans_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "laporans_id", "id");
    }
}

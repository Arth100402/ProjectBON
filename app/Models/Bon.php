<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }

    function acc()
    {
        return $this->hasMany(Acc::class, "bons_id", "id");
    }

    function detailbon()
    {
        return $this->hasMany(DetailBon::class, "bons_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "bons_id", "id");
    }
}

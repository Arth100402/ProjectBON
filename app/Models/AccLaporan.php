<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccLaporan extends Model
{
    use HasFactory;

    function laporan()
    {
        return $this->belongsTo(Laporan::class, "laporans_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}

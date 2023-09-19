<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccReimburse extends Model
{
    use HasFactory;

    function reimburse()
    {
        return $this->belongsTo(Reimburse::class, "reimburses_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}

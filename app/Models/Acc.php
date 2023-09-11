<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acc extends Model
{
    use HasFactory;
    protected $table = "accs";

    function bon()
    {
        return $this->belongsTo(Bon::class, "bons_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}

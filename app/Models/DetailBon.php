<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBon extends Model
{
    use HasFactory;
    protected $table = "detailbons";

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}

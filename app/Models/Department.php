<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "departements";
    function user()
    {
        return $this->hasMany(User::class, "departement_id", "id");
    }
}

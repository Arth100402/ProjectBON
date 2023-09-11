<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";

    function project()
    {
        return $this->hasMany(Project::class, "customers_id", "id");
    }
}

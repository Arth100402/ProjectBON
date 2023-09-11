<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    function Vehicle(){
        return $this->hasMany(Vehicle::class,"vehicle_id","id");
    }
}

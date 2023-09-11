<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $table = "maintenances";

    function detailMaintenance()
    {
        return $this->hasMany(DetailMaintenance::class, "maintenances_id", "id");
    }
    function Workshop()
    {
        return $this->belongsTo(Workshop::class,"workshops_id","id");
    }
    function vehicle()
    {
        return $this->belongsTo(Vehicle::class, "vehicles_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id","id");
    }
}

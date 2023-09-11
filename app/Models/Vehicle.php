<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "vehicles";

    function rentVehicle()
    {
        return $this->belongsToMany(User::class, "rentvehicle", "vehicles_id", "users_id")
            ->withPivot(["tglSewa", "tglSelesai", "keterangan", "biayaSewa", "kmAwal", "kmAkhir", "totalLiter", "lokasiPengisian", "status"]);
    }

    function maintenance()
    {
        return $this->hasMany(Maintenance::class, "vehicles_id", "id");
    }

    function location()
    {
        return $this->belongsTo(Location::class, "vehicle_id", "id");
    }

    function user()
    {
        return $this->belongsToMany(User::class, 'rentvehicle', 'vehicles_id', 'users_id')->withPivot(["tglSewa", "tglSelesai", "keterangan", "biayaSewa", "kmAwal", "kmAkhir", "totalLiter", "lokasiPengisian", "status"]);
    }
}

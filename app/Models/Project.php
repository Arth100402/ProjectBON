<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "projects";

    function customer()
    {
        return $this->belongsTo(Customer::class, "customers_id", "id");
    }

    function bon()
    {
        return $this->hasMany(Bon::class, "projects_id", "id");
    }

    function reimburse()
    {
        return $this->hasMany(Reimburse::class, "projects_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "projects_id", "id");
    }

    function detailreimburse()
    {
        return $this->hasMany(DetailReimburse::class, "projects_id", "id");
    }
}

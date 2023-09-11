<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMaintenance extends Model
{
    use HasFactory;
    protected $table = "detailmaintenances";

    function maintenance()
    {
        return $this->belongsTo(Maintenance::class, "maintenances_id", "id");
    }

    function sparepart()
    {
        return $this->belongsTo(Sparepart::class, "spareparts_id", "id");
    }
}

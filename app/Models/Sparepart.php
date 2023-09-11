<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    function detailMaintenance()
    {
        return $this->hasMany(DetailMaintenance::class, "spareparts_id", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model
{
    use HasFactory;

    function project()
    {
        return $this->belongsTo(Project::class, "projects_id", "id");
    }

    function accreimburse()
    {
        return $this->hasMany(AccReimburse::class, "reimburses_id", "id");
    }

    function detailreimburse()
    {
        return $this->hasMany(DetailReimburse::class, "reimburses_id", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    function type()
    {
        return $this->hasMany(Type::class, "categories_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "categories_id", "id");
    }

    function detailreimburse()
    {
        return $this->hasMany(DetailReimburse::class, "categories_id", "id");
    }
}

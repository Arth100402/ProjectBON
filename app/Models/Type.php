<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    function category()
    {
        return $this->belongsTo(Category::class, "categories_id", "id");
    }

    function detaillaporan()
    {
        return $this->hasMany(DetailLaporan::class, "types_id", "id");
    }

    function detailreimburse()
    {
        return $this->hasMany(DetailReimburse::class, "types_id", "id");
    }
}

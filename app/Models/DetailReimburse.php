<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReimburse extends Model
{
    use HasFactory;

    function reimburse()
    {
        return $this->belongsTo(Reimburse::class, "reimburses_id", "id");
    }

    function project()
    {
        return $this->belongsTo(Project::class, "projects_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }

    function category()
    {
        return $this->belongsTo(Category::class, "categories_id", "id");
    }

    function type()
    {
        return $this->belongsTo(Type::class, "types_id", "id");
    }
}

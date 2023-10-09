<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailBon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "detailbons";

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }

    function bon()
    {
        return $this->belongsTo(Bon::class, "bons_id", "id");
    }

    function project()
    {
        return $this->belongsTo(Project::class, "projects_id", "id");
    }
}

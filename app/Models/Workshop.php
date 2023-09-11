<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "workshops";
    function Maintenance()
    {
        return $this->hasMany(Maintenance::class,"workshops_id","id");
    }
}

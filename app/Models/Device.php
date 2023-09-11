<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "devices";
    function projectActivityDetail()
    {
        return $this->belongsTo(ProjectActivityDetail::class, "projectactivitydetail_id", "id");
    }
    function deviceCategory()
    {
        return $this->hasOne(deviceCategory::class, "deviceCategory_id", "id");
    }
}

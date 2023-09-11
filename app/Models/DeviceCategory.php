<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "deviceCategory";
    function Device()
    {
        return $this->belongsTo(Device::class, "deviceCategory_id", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectActivityDetail extends Model
{
    use HasFactory;
    protected $table = "projectactivitydetail";
    function historyProjectReport()
    {
        return $this->belongsToMany(User::class, "historyprojectreport", "projectactivitydetail_id", "users_id")
            // ->using(HistoryProjectReport::class)
            ->withPivot(["namaDevice", "jenisDevice", "tipeDevice", "merkDevice", "ipAddress", "port", "serialNumber", "keteranganPerubahan"]);
    }

    function device()
    {
        return $this->hasMany(Device::class, "projectactivitydetail_id", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "projects";
    function customer()
    {
        return $this->belongsTo(Customer::class, "customers_id", "id");
    }
    function projectAssign()
    {
        return $this->belongsToMany(User::class, "projectassign", "projects_id", "users_id")
            // ->using(ProjectAssign::class)
            ->withPivot(["statusKaryawan"]);
    }

    function projectActivityDetail()
    {
        return $this->belongsToMany(User::class, "projectactivitydetail", "projects_id", "users_id")
            // ->using(ProjectActivityDetail::class)
            ->withPivot(["id", "namaAktifitas", "keterangan", "waktuTiba", "waktuSelesai", "tglGaransi"]);
    }
}

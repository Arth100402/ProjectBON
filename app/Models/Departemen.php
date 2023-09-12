<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $table = "departements";

    function user()
    {
        return $this->hasMany(User::class, "departement_id", "id");
    }
    public function jabatanPengaju()
    {
        return $this->belongsToMany(Jabatan::class, 'departemen_jabatan', 'departemen_id', 'jabatanPengaju')->withPivot('status')->withTimestamps();
    }

    public function jabatanAcc()
    {
        return $this->belongsToMany(Jabatan::class, 'departemen_jabatan', 'departemen_id', 'jabatanAcc')->withPivot('status')->withTimestamps();
    }
}

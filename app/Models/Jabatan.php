<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = "jabatans";

    function user()
    {
        return $this->hasMany(User::class, "jabatan_id", "id");
    }
    public function departemen1()
    {
        return $this->belongsToMany(Departemen::class, 'departemen_jabatan', 'jabatanPengaju', 'departemen_id')->withPivot('status')->withTimestamps();
    }

    public function departemen2()
    {
        return $this->belongsToMany(Departemen::class, 'departemen_jabatan', 'jabatanAcc', 'departemen_id')->withPivot('status')->withTimestamps();
    }
}

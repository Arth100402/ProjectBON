<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = "users";

    function department()
    {
        return $this->belongsTo(Department::class, "departement_id", "id");
    }

    function projectAssign()
    {
        return $this->belongsToMany(Project::class, "projectassign", "users_id", "projects_id")
            // ->using(ProjectAssign::class)
            ->withPivot(["roles_id"]);
    }

    function projectActivityDetail()
    {
        return $this->belongsToMany(Project::class, "projectactivitydetail", "users_id", "projects_id")
            ->withPivot(["id", "namaAktifitas", "keterangan", "waktuTiba", "waktuSelesai"]);
    }

    function historyProjectReport()
    {
        return $this->belongsToMany(ProjectActivityDetail::class, "historyprojectreport", "users_id", "projectactivitydetail_id")
            // ->using(HistoryProjectReport::class)
            ->withPivot(["namaDevice", "jenisDevice", "tipeDevice", "merkDevice", "ipAddress", "port", "serialNumber", "keteranganPerubahan"]);
    }

    function rentVehicle()
    {
        return $this->belongsToMany(Vehicle::class, "rentvehicle", "users_id", "vehicles_id")
            // ->using(RentVehicle::class)
            ->withPivot(["tglSewa", "tglSelesai", "keterangan", "biayaSewa", "kmAwal", "kmAkhir", "totalLiter", "lokasiPengisian", "status"]);
    }

    function vehicle()
    {
        return $this->belongsToMany(Vehicle::class, 'rentvehicle', 'users_id', 'vehicles_id')->withPivot(["tglSewa", "tglSelesai", "keterangan", "biayaSewa", "kmAwal", "kmAkhir", "totalLiter", "lokasiPengisian", "status"]);
    }




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

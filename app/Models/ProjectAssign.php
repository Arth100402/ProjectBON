<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectAssign extends Pivot
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "projectassign";
    protected $fillable=[
        'users_id',
        'projects_id',
        'statusKaryawan',
    ];
}

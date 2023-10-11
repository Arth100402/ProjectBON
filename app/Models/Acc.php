<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acc extends Model
{
    use HasFactory;
    protected $table = "accs";
    protected $attributes = ['level' => 0, 'threshold' => 0, 'thresholdChange' => 0];

    function bon()
    {
        return $this->belongsTo(Bon::class, "bons_id", "id");
    }

    function user()
    {
        return $this->belongsTo(User::class, "users_id", "id");
    }
}

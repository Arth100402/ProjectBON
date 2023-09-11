<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=5;$i++){
            DB::table('maintenances')->insert([
                [
                    "tglMaintenance"=>now(),
                    "keluhan"=>"keluhan".($i),
                    "totalBiaya"=>rand(1, 50) * 100000,
                    "hargaService"=>rand(1, 20) * 100000,
                    "image" => "service".($i).".jpg",
                    "km"=>rand(0,15000),
                    "workshops_id"=>($i),
                    "users_id"=>($i),
                    "vehicles_id"=>($i)
                ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Internal', 'External'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('rentvehicle')->insert([
                [
                    "vehicles_id" => ($i),
                    "users_id" => ($i),
                    "tglSewa" => now(),
                    "tglSelesai" => date('Y-m-d', strtotime('+5 years')),
                    "tujuan" => "tujuan" . ($i),
                    "status" => $status[rand(0, 1)],
                    "image" => "jaminan".($i).".jpg",
                    "imagekmawalakhir" => "kmawal".($i).".jpg"
                ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('devices')->insert([
                [
                    "nama" => "device" . ($i),
                    "deviceCategory_id" =>($i),
                    "tipe" => "tipe" . ($i),
                    "merk" => "merk" . ($i),
                    "username" => "username" . ($i),
                    "password" => "password" . ($i),
                    "ipaddress" => rand(100, 999) . "." . rand(100, 999) . "." . rand(100, 999) . "." . ($i),
                    "port" => rand(0000, 9999),
                    "serialnumber" => rand(00000, 99999),
                    "image" => "device".($i).".jpg"
                ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lokasi = ["Jakarta","Surabaya","Bandung","Depok","Malang","Bogor","Gresik"];
        for ($i = 0; $i < count($lokasi); $i++) {
            DB::table('locations')->insert([
                [
                    "nama" => $lokasi[$i]
                ]
            ]);

        }
    }
}

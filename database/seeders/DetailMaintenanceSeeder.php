<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=5;$i++){
            DB::table('detailmaintenances')->insert([
                [
                    "spareparts_id"=>($i),
                    "subtotal"=>rand(1, 50) * 100000,
                    "maintenances_id"=>($i)
                ]
            ]);
        }
    }
}

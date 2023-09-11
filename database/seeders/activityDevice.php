<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class activityDevice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ["on", "off"];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('activitydevice')->insert([
                [
                    "projectactivitydetail_id" => ($i),
                    "device_id" => ($i),
                    "status" => "Proses"
                ]
            ]);
        }
    }
}

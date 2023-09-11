<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectActivityDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('projectactivitydetail')->insert([
                [
                    "projects_id" => 1,
                    "namaAktifitas" => "aktifitas" . ($i),
                    "tglAktifitas" => Date("y:m:d", strtotime("+" . ($i - 1) . " days"))
                ]
            ]);
            DB::table('projectactivitydetail')->insert([
                [
                    "projects_id" => 2,
                    "namaAktifitas" => "aktifitas" . ($i),
                    "tglAktifitas" => Date("y:m:d", strtotime("+" . ($i - 1) . " days"))
                ]
            ]);
        }
        DB::table('projectactivitydetail')->insert([
            [
                "projects_id" => 3,
                "namaAktifitas" => "aktifitas" . ($i),
                "tglAktifitas" => Date("y:m:d", strtotime("+" . ($i - 1) . " days"))
            ]
        ]);
    }
}

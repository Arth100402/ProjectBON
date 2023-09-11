<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('projectassign')->insert([
                [
                    "users_id" => ($i),
                    "projectactivitydetail_id" => ($i),
                    "roles_id" => ($i),
                    "keterangan" => "Keterangan " . ($i),
                    "waktuTiba" => "08:00:00",
                    "waktuSelesai" => "12:00:00",
                    "image" => "activity" . ($i) . ".jpg",
                    "latitude" => "lat".($i),
                    "longitude" => "lon".($i)
                ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = ["Super", "Operational", "TXN", "Technical"];
        for ($i = 0; $i <= 3; $i++) {
            DB::table('departements')->insert([
                [
                    "name" => $department[$i]
                ]
            ]);
        }
    }
}

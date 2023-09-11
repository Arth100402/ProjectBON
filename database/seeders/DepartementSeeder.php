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
        $department = ["Super", "Operational", "TXN", "Technical", "Sales"];
        for ($i = 0; $i <= 4; $i++) {
            DB::table('departements')->insert([
                [
                    "name" => $department[$i]
                ]
            ]);
        }
    }
}

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
        $department = ["Super", "Operation", "TXN", "Technical", "Sales IT", "Warehouse", "HRD", "Finance"];
        for ($i = 0; $i < count($department); $i++) {
            DB::table('departements')->insert([
                [
                    "name" => $department[$i]
                ]
            ]);
        }
    }
}

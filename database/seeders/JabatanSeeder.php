<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ["Karyawan", "Supervisor", "Super Admin"];
        for ($i = 0; $i <= 2; $i++) {
            DB::table('jabatans')->insert([
                [
                    "name" => $roles[$i]
                ]
            ]);
        }
    }
}

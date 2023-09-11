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
        $roles = ["Karyawan", "Supervisor", "Manager", "General Manager", "Wakil Direktur", "Direktur", "Super Admin"];
        for ($i = 0; $i <= 6; $i++) {
            DB::table('jabatans')->insert([
                [
                    "name" => $roles[$i]
                ]
            ]);
        }
    }
}

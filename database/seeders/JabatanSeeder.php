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
        $roles = ["Karyawan", "Supervisor", "Kasir", "Manager", "General Manager", "Wakil Direktur", "Direktur", "Super Admin"];
        for ($i = 0; $i < count($roles); $i++) {
            DB::table('jabatans')->insert([
                [
                    "name" => $roles[$i]
                ]
            ]);
        }
    }
}

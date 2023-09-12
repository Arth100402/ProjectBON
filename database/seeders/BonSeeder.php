<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('bons')->insert([
                [
                    "tglPengajuan" => now(),
                    "users_id" => ($i),
                    "total" => 10000*$i
                ]
            ]);
        }
    }
}

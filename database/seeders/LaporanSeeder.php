<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('laporans')->insert([
                [
                    "tglPengajuan" => now(),
                    "users_id" => ($i),
                    "totalPengeluaran" => 10000*$i,
                    "bonSementara" => 10000*$i
                ]
            ]);
        }
    }
}

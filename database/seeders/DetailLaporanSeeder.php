<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('detaillaporans')->insert([
                [
                    "laporans_id" => ($i),
                    "tanggal" => now(),
                    "projects_id" => ($i),
                    "users_id" => ($i),
                    "categories_id" => ($i),
                    "types_id" => ($i),
                    "vendor" => "vendor".($i),
                    "keterangan" => "keterangan".($i),
                    "pengeluaran" => 1000000*$i,
                    "bons_id" => ($i)
                ]
            ]);
        }
    }
}

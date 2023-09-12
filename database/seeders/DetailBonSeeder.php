<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailBonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('detailbons')->insert([
                [
                    "bons_id" => ($i),
                    "tglMulai" => now(),
                    "tglAkhir" => now(),
                    "asalKota" => "Surabaya",
                    "tujuan" => "Surabaya",
                    "users_id" => ($i),
                    "projects_id" => ($i),
                    "agenda" => "agenda".($i),
                    "keterangan" => "keterangan".($i),
                ]
            ]);
        }
    }
}

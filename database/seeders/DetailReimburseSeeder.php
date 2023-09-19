<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailReimburseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('detailreimburses')->insert([
                [
                    "reimburses_id" => ($i),
                    "tanggal" => now(),
                    "kota" => "kota".($i),
                    "projects_id" => ($i),
                    "users_id" => ($i),
                    "categories_id" => ($i),
                    "types_id" => ($i),
                    "vendor" => "vendor".($i),
                    "keterangan" => "keterangan".($i),
                    "quantity" => ($i),
                    "biaya" => 10000*$i,
                    "pengeluaran" => 10000*$i
                ]
            ]);
        }
    }
}

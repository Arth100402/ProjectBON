<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('customers')->insert([
                [
                    "nama"=>"customer".($i),
                    "alamat"=>"alamat".($i),
                    "instansi"=>"customer".($i),
                    "notelp" => "08".($i).rand(000000000,999999999),
                    "email" => "customer".($i)."@gmail.com",
                ]
            ]);
        }
    }
}

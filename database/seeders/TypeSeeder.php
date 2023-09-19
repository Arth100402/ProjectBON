<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                "categories_id" => 1,
                "jenis" => "Toll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 1,
                "jenis" => "BBM"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 1,
                "jenis" => "Sewa Kendaraan"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 1,
                "jenis" => "Ojek Online"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 1,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 2,
                "jenis" => "Makan"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 2,
                "jenis" => "Minum"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 2,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 3,
                "jenis" => "Snack"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 3,
                "jenis" => "Kopi"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 3,
                "jenis" => "Softdrink"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 3,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Buku"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Alat Tulis"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Materai"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Kwitansi"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Foto Copy"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 4,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 5,
                "jenis" => "Swab"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 5,
                "jenis" => "Medical Check Up"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 5,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 6,
                "jenis" => "Maintenance Kendaraan"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 6,
                "jenis" => "Paket Data"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 6,
                "jenis" => "Pulsa Telpon"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 6,
                "jenis" => "Token Listrik"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 6,
                "jenis" => "Dll"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 7,
                "jenis" => "Hotel"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 7,
                "jenis" => "Penginapan"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 7,
                "jenis" => "Tiket"
            ]
        ]);
        DB::table('types')->insert([
            [
                "categories_id" => 7,
                "jenis" => "Dll"
            ]
        ]);
    }
}

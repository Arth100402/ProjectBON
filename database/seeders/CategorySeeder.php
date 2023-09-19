<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                "name" => "Transportasi"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "Kompensasi"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "Entertainment"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "ATK"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "Medis"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "Operasional"
            ]
        ]);
        DB::table('categories')->insert([
            [
                "name" => "Akomodasi"
            ]
        ]);
    }
}

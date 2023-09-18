<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                "name" => "Super POG",
                "email" => "super@gmail.com",
                "password" => Hash::make("super"),
                "jabatan_id" => 4,
                "username" => "super",
                "departement_id" => 4
            ]
        ]);
        DB::table('users')->insert([
            [
                "name" => "Kasir",
                "email" => "kasir@gmail.com",
                "password" => Hash::make("kasir"),
                "jabatan_id" => 8,
                "username" => "kasir",
                "departement_id" => 9
            ]
        ]);
        DB::table('users')->insert([
            [
                "name" => "Finance Manager",
                "email" => "fm@gmail.com",
                "password" => Hash::make("fm"),
                "jabatan_id" => 3,
                "username" => "fm",
                "departement_id" => 8
            ]
        ]);
        for ($i = 0; $i <= 10; $i++) {
            DB::table('users')->insert([
                [
                    "name" => "User" . ($i),
                    "email" => "User" . ($i) . "@gmail.com",
                    "password" => Hash::make("user" . ($i)),
                    "jabatan_id" => rand(1, 2),
                    "username" => "User" . ($i),
                    "departement_id" => rand(4, 5)
                ]
            ]);
        }
    }
}

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
                "jabatan_id" => 3,
                "username" => "super",
                "departement_id" => 4
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
                    "departement_id" => 4
                ]
            ]);
        }
    }
}

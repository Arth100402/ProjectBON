<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ["K3", "Survey", "Helpdesk", "Teknisi", "Leader"];
        for ($i = 0; $i <= 4; $i++) {
            DB::table('roles')->insert([
                [
                    "name" => $roles[$i]
                ]
            ]);
        }
    }
}

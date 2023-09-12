<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = ["Super", "Operation", "TXN", "Technical", "Sales IT",  "Warehouse", "HRD"];
        $roles = ["Staff", "Supervisor", "Manager", "General Manager", "Wakil Direktur", "Direktur", "Super Admin"];
        for ($i = 1; $i <= count($department); $i++) {
            for ($j = 1; $j <= count($roles); $j++) {
                for ($k = 1; $k <= count($roles); $k++) {
                    if ($j > $k || $j == $k) continue;
                    DB::table('acc_access')->insert([
                        [
                            "departId" => $i,
                            "jabatanPengaju" => $j,
                            "jabatanAcc" => $k,
                            "status" => "disable"
                        ]
                    ]);
                }
            }
        }
    }
}

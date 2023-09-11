<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class HistoryProjectReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=5;$i++){
            DB::table('historyprojectreport')->insert([
                [
                    "projects_id"=>($i),
                    "users_id"=>($i),
                    "keteranganPerubahan"=>"masalah".($i)
                ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ["Menunggu", "Proses", "Ditunda", 'Selesai'];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('projects')->insert([
                [
                    "idOpti" => "idOpti" . ($i),
                    "namaOpti" => "namaOpti" . ($i),
                    "instansi" => "instansi" . ($i),
                    "customers_id" => ($i),
                    "telepon" => "08" . ($i) . rand(000000000, 999999999),
                    "users_id" => ($i),
                    "tglBuat" => now(),
                    "tglRealisasi" => now(),
                    "kebutuhan" => "kebutuhan" . ($i),
                    "actplan" => "actplan" . ($i),
                    "estNominal" => rand(1, 50) * 100000,
                    "status" => $status[rand(0, 3)],
                    "statusBarang" => "statusBarang" . ($i),
                    "statusRevisi" => "statusRevisi" . ($i),
                    "posisi" => "Surabaya",
                    "statusBarangReady" => "Ready",
                    "statusPinjam" => "statusPinjam" . ($i),
                    "divisi" => "divisi" . ($i),
                    "pbar" => "pbar" . ($i),
                    "onUpdate" => "onUpdate" . ($i),
                    "totalPaket" => rand(0, 100),
                    "profitDouble" => rand(1, 50) * 100000,
                    "profitSingle" => rand(1, 50) * 100000,
                    "statusRegisterPortal" => 1,
                    "deadline" => date('Y-m-d', strtotime('+5 days')),
                    "noPaket" => "1604-".($i)."SBY",
                    "bendera" => "1604-".($i)."DIY"
                ]
            ]);
        }
    }
}

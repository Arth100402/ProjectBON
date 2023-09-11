<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = ["Mobil Penumpang", "Mobil Barang", "Sepeda Motor"];
        for ($i = 1; $i <= 5; $i++) {
            DB::table('vehicles')->insert([
                [
                    "jenis" => $jenis[rand(0, 2)],
                    "merk" => "merk" . ($i),
                    "tipe" => "tipe" . ($i),
                    "warna" => "warna" . ($i),
                    "tahun" => date('Y'),
                    "noMesin" => rand(1111111111, 9999999999),
                    "noKerangka" => rand(1111111111, 9999999999),
                    "noPolLama" => "L " . ($i + 100) . " LD",
                    "location_id" => rand(1, 7),
                    "tanggalBayarPajakTahunan" => date('Y-m-d', strtotime('+1 years')),
                    "masaBerlakuSTNK" => date('Y-m-d', strtotime('+5 years')),
                    "atasNamaSTNK" => "user" . ($i),
                    "posisiBPKB" => "user" . ($i),
                    "tanggalKIR" => date('Y-m-d'),
                    "kodeGPS" => rand(11111, 99999),
                    "namaGPS" => "namaGPS" . ($i),
                    "kodeBarcode" => "barcode" . ($i),
                    "noPol" => "L " . ($i) . " LD",
                    "tglBayarGPS" => date('Y-m-d', strtotime('+5 years')),
                    "image" => "vehicle" . ($i) . ".jpg"
                ]
            ]);
        }
    }
}

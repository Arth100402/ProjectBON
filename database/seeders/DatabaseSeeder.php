<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(DepartementSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(BonSeeder::class);
        $this->call(DetailBonSeeder::class);
        $this->call(AccAccessSeeder::class);
        $this->call(LaporanSeeder::class);
        $this->call(DetailLaporanSeeder::class);
        $this->call(ReimburseSeeder::class);
        $this->call(DetailReimburseSeeder::class);
    }
}

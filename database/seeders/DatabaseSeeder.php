<?php

namespace Database\Seeders;

use App\Models\Workshop;
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
        // User::factory(10)->create();
        $this->call(JabatanSeeder::class);
        $this->call(deviceCategorySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(WorkshopSeeder::class);
        $this->call(SparepartSeeder::class);
        $this->call(DepartementSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ProjectActivityDetailSeeder::class);
        $this->call(ProjectAssignSeeder::class);
        $this->call(DeviceSeeder::class);
        $this->call(HistoryProjectReportSeeder::class);
        $this->call(RentVehicleSeeder::class);
        $this->call(MaintenanceSeeder::class);
        $this->call(DetailMaintenanceSeeder::class);
        $this->call(ActivityDevice::class);
    }
}

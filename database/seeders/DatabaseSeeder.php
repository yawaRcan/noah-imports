<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([ 
            ExternalShipperSeeder::class, 
            ImportDutySeeder::class, 
            CurrencySeeder::class, 
            PaymentSeeder::class, 
            ParcelStatusSeeder::class, 
            PaymentStatusSeeder::class, 
            ShipmentTypeSeeder::class, 
            ShipmentModeSeeder::class,  
            SettingSeeder::class, 
            CountrySeeder::class,
            BranchSeeder::class, 
            RateSeeder::class,
            TimezoneSeeder::class, 
            AdminSeeder::class, 
            UserSeeder::class, 
            ShippingSeeder::class,
            PickupStationSeeder::class,
            EmailTemplateSeeder::class,
            CarMakeModelSeeder::class,
        ]);
    }
}

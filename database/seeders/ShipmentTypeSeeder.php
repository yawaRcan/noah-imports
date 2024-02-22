<?php

namespace Database\Seeders;

use App\Models\ShipmentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys = [ 
            ["name"=>"Chipboard packaging"],
            ["name"=>"Container Vessels"],
            ["name"=>"Corrugated boxes"],
            ["name"=>"Document Parcels"],
            ["name"=>"Foil sealed bags"],
            ["name"=>"Heavy Container's"],
            ["name"=>"Pallets"],
            ["name"=>"Paperboard boxes"],
            ["name"=>"Plastic boxes"],
            ["name"=>"Poly bags"],
            ["name"=>"Rigid boxes"] 
        ];

        $count = ShipmentType::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = ShipmentType::create($arr);
            }
        }
    }
}

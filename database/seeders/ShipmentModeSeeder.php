<?php

namespace Database\Seeders;

use App\Models\ShipmentMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys = [ 
            ["name"=>"Air Freight Delivery"],
            ["name"=>"Express Domestic"],
            ["name"=>"International Economy"],
            ["name"=>"International Priority"],
            ["name"=>"Priority Mail"],
            ["name"=>"Priority Mail Express"],
            ["name"=>"Road Freight Delivery"],
            ["name"=>"Sea Delivery"]
             
            
        ];

        $count = ShipmentMode::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = ShipmentMode::create($arr);
            }
        }
    }
}

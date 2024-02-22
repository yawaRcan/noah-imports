<?php

namespace Database\Seeders;

use App\Models\ConfigStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParcelStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         
            $arrys =[ 
                ["name"=>"Pending",  "slug" => "pending", "color"=> "#461234"],
                ["name"=>"Processing", "slug" => "processing", "color"=>"#FF8819"],
                ["name"=>"In Transit", "slug" => "in-transit", "color"=>"#6C7621"],
                ["name"=>"In transit to be delivered", "slug" => "in-transit-to-be-delivered", "color"=>"#79C80B"],
                ["name"=>"Delivered", "slug" => "delivered", "color"=>"#0EA41B"],
                ["name"=>"Cancelled", "slug" => "cancelled", "color"=>"#E60000"],
                ["name"=>"Delayed", "slug" => "delayed", "color"=>"#8A1B30"],
                ["name"=>"Ready for Pickup", "slug" => "ready-for-pickup", "color"=>"#07D169"],
                ["name"=>"At warehouse Miami", "slug" => "at-warehouse-miami", "color"=>"#221375"],
                ["name"=>"Draft", "slug" => "draft", "color"=>"#000"],
                ["name"=>"Delete", "slug" => "delete", "color"=>"#000"],
                ["name"=>"Active", "slug" => "active", "color"=>"#0EA41B"],
                ["name"=>"Customs Curacao", "slug" => "customs-curacao", "color"=>"#FFEF0F"],
                ["name"=>"Flight Cancelation pending next flight", "slug" => "flight-cancelation-pending-next-flight", "color"=>"#FF0000"],
                ["name"=>"Delayed At Customs Curacao", "slug" => "delayed-at-customs-curacao", "color"=>"#DE0000"],
                ["name"=>"At Warehouse Curacao", "slug" => "at-warehouse-curacao", "color"=>"#FF7837"]  
                
        ];

        $count = ConfigStatus::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = ConfigStatus::create($arr);
            }
        }
    }
}

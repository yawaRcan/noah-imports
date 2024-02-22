<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentStatus;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys =[ 
                ["name"=>"Unpaid","slug"=>"unpaid","value"=> 0, "color"=> "#461234"],
                ["name"=>"Paid","slug"=>"paid","value"=> 1, "color"=> "#FF8819"],
                ["name"=>"Pending","slug"=>"pending","value"=> 2, "color"=> "#6C7621"],
                ["name"=>"Approve","slug"=>"approve","value"=> 3, "color"=> "#0EA41B"], 
                ["name"=>"Reject","slug"=>"reject","value"=> 4, "color"=> "#0EA41B"], 
                
        ];

        $count = PaymentStatus::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = PaymentStatus::create($arr);
            }
        }
    }
}

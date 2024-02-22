<?php

namespace Database\Seeders;
 
use App\Models\ShippingAddress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys =[ 
            ["country_id" => "167" , "first_name" => "noah" ,"last_name" => "imports" , "email" => "noah@gmail.com" , "initial_country" => "us","country_code"=> 1 ,"phone" => "987654365" , "state" => "California" , "city" => "Miami" , "address" => "America" , "zipcode" => "34444" , "crib" => "123" , "morphable_type" => "App\\Models\\User" , "morphable_id" => "1" , "status" => "0"],
            ["country_id" => "167" , "first_name" => "noah" ,"last_name" => "imports" , "email" => "noah@gmail.com" , "initial_country" => "us","country_code"=> 92 ,"phone" => "43456655432" , "state" => "New York" , "city" => "Miami" , "address" => "America" , "zipcode" => "34444" , "crib" => "123" , "morphable_type" => "App\\Models\\Admin" , "morphable_id" => "1" , "status" => "0"]
              ];
        $count = ShippingAddress::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = ShippingAddress::create($arr);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys = [ 
           ["code"=>"USD","name"=>"US Dollar","symbol"=>"$","value"=>"1.8026"],
           ["code"=>"EUR","name"=>"Euro","symbol"=>"€","value"=>"2.1808"],
           ["code"=>"ANG","name"=>"Netherlands Antilles Guilder","symbol"=>"ƒ","value"=>"1"],
           ["code"=>"GBP","name"=>"Pound Sterling","symbol"=>"£","value"=>"2.546"],
           ["code"=>"TRY","name"=>"Turkish lira","symbol"=>"₺","value"=>"0.2147"],
           ["code"=>"JMD","name"=>"JMD","symbol"=>"$","value"=>"1"],
           ["code"=>"BTC","name"=>"Bitcoin","symbol"=>"₿","value"=>"0.0001"],
           ["code"=>"AWG","name"=>"Arubaanse Florin","symbol"=>"Afl.","value"=>"1.00"]
        ];

        $count = Currency::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = Currency::create($arr);
            }
        }
    }
}

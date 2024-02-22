<?php

namespace Database\Seeders;

use App\Models\ExternalShipper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrys =[
            ["name"=>"FedEx",'icon' => '1622341188FD689C350859C39.PNG', 'slug' => 'fedex'],
            ["name"=>"DHL Express",'icon' => '1622341195CA7A97EBE7D1E45.PNG', 'slug' => 'dhl'],
            ["name"=>"UPS",'icon' => '16229647435698DC03C3985F9.PNG', 'slug' => 'ups'],
            ["name"=>"TNT",'icon' => '162234045439D50389F5CC968.PNG', 'slug' => 'tnt'],
            ["name"=>"USPS",'icon' => '1625629048309C8D69FC59835.PNG', 'slug' => 'usps'],
            ["name"=>"Amazon Shipping",'icon' => '16256298441CEAEA79D7B457E.PNG', 'slug' => 'amazon'],
            ["name"=>"STONE3PL",'icon' => '162665033388C59D03369FC59.PNG', 'slug' => 'stone3pl'],
            ["name"=>"Lasership",'icon' => '1627959385BCA77914EDE5AE7.PNG', 'slug' => 'lasership'],
            ["name"=>"China Post",'icon' => '16285409879C085D3F593C896.PNG', 'slug' => 'china-post'],
            ["name"=>"Global Cainiao Shipping",'icon' => '1628541173E1CBE7459A7DEA7.JPG', 'slug' => 'cainiao'],
            ["name"=>"Noah Imports Drop off",'icon' => '1681668570C963983C8FD9055.PNG', 'slug' => 'noah-import']
            ];

        $count = ExternalShipper::count();
        if($count == 0){
            foreach($arrys as $arr){
                $data = ExternalShipper::create($arr);
            }
        }
    }
}

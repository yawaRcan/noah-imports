<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarMakeModel;

class CarMakeModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makeModelarr = [
                [
                    "year" => '2020',
                    "make" => "Audi",
                    "model" => "Q3",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Malibu",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "Escalade ESV",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Corvette",
                    "category" => "Coupe, Convertible"
                ],
                [
                    "year" => '2020',
                    "make" => "Acura",
                    "model" => "RLX",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Silverado 2500 HD Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "BMW",
                    "model" => "3 Series",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Chrysler",
                    "model" => "Pacifica",
                    "category" => "Van/Minivan"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Colorado Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "BMW",
                    "model" => "X3",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Acura",
                    "model" => "TLX",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Silverado 3500 HD Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "BMW",
                    "model" => "7 Series",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Fusion",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Buick",
                    "model" => "Envision",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Audi",
                    "model" => "SQ5",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Audi",
                    "model" => "R8",
                    "category" => "Coupe, Convertible"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Traverse",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Acura",
                    "model" => "MDX",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "INFINITI",
                    "model" => "QX80",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Buick",
                    "model" => "Encore",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Sierra 2500 HD Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Insight",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "XT6",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "XT5",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "XT4",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Buick",
                    "model" => "Enclave",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Audi",
                    "model" => "Q5",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Santa Fe",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "EcoSport",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Escape",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Mustang",
                    "category" => "Coupe, Convertible"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Sonata",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Edge",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Camaro",
                    "category" => "Convertible"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Kona Electric",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Equinox",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Sierra 3500 HD Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Jeep",
                    "model" => "Gladiator",
                    "category" => "Pickup",

                ],
                [
                    "year" => '2020',
                    "make" => "BMW",
                    "model" => "X7",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "CT6-V",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Audi",
                    "model" => "A7",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Blazer",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "F150 SuperCrew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Suburban",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Civic",
                    "category" => "Hatchback, Sedan, Coupe"
                ],
                [
                    "year" => '2020',
                    "make" => "Jeep",
                    "model" => "Compass",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "Escalade",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chrysler",
                    "model" => "Voyager",
                    "category" => "Van/Minivan"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Accord Hybrid",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Terrain",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Spark",
                    "category" => "Hatchback"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Sierra 1500 Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "NEXO",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Veloster",
                    "category" => "Coupe"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Silverado 1500 Crew Cab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Genesis",
                    "model" => "G70",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Cadillac",
                    "model" => "CT5",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Odyssey",
                    "category" => "Van/Minivan"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Elantra GT",
                    "category" => "Hatchback"
                ],
                [
                    "year" => '2020',
                    "make" => "Acura",
                    "model" => "RDX",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Yukon XL",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Ranger SuperCab",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Expedition MAX",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Kona",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "INFINITI",
                    "model" => "QX50",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Dodge",
                    "model" => "Durango",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Yukon",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Palisade",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Ridgeline",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Jeep",
                    "model" => "Cherokee",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Bolt EV",
                    "category" => "Hatchback"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Expedition",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Elantra",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Passport",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Dodge",
                    "model" => "Charger",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Accord",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "INFINITI",
                    "model" => "QX60",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Venue",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "Pilot",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Jeep",
                    "model" => "Grand Cherokee",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Tahoe",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "GMC",
                    "model" => "Acadia",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Impala",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "CR-V",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "BMW",
                    "model" => "X5",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "INFINITI",
                    "model" => "Q60",
                    "category" => "Coupe",

                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Ranger SuperCrew",
                    "category" => "Pickup"
                ],
                [
                    "year" => '2020',
                    "make" => "Chevrolet",
                    "model" => "Trax",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Ioniq Plug-in Hybrid",
                    "category" => "Hatchback"
                ],
                [
                    "year" => '2020',
                    "make" => "Jaguar",
                    "model" => "E-PACE",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Tucson",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Ford",
                    "model" => "Explorer",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Honda",
                    "model" => "HR-V",
                    "category" => "SUV"
                ],
                [
                    "year" => '2020',
                    "make" => "Jaguar",
                    "model" => "I-PACE",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "INFINITI",
                    "model" => "Q50",
                    "category" => "Sedan",

                ],
                [
                    "year" => '2020',
                    "make" => "Genesis",
                    "model" => "G80",
                    "category" => "Sedan"
                ],
                [
                    "year" => '2020',
                    "make" => "Jaguar",
                    "model" => "F-PACE",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Jeep",
                    "model" => "Renegade",
                    "category" => "SUV",

                ],
                [
                    "year" => '2020',
                    "make" => "Hyundai",
                    "model" => "Accent",
                    "category" => "Sedan"
                ]

        ];

        if(CarMakeModel::count() == 0){
            foreach($makeModelarr as $arr){
                CarMakeModel::create($arr);
            }
        }
    }
}

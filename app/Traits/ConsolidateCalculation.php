<?php

namespace App\Traits; 

trait ConsolidateCalculation
{
    use AirCalculator, SeaCalculator;

    protected $totaldiscount;
    protected $totalTax;
    protected $totalAmount; 
    protected $totalAirChargableWeight;
    protected $totalSeaChargableWeight;
}
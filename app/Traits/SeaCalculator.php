<?php

namespace App\Traits;

use App\Models\ImportDuty;

trait SeaCalculator
{
   //dimension
   public $length;
   public $width;
   public $height;
   public $price;
   public $import_duty;
   public $ob;
   public $discount_type;
   
   //main
   private $volume;
   private $cobic_feet;
   private $chargeable_weight_air;
   private $chargeable_dimension;
   private $shipping_price;
   private $clearance_charges;
   private $insurance_invoice_value;
   private $item_value;
   private $insurance;
   private $total;

   //constructor
   public function __construct(){
       global $ec;
   }
   
   //calculate volume
   private function volumeInches()
   {
       return ($this->length * $this->width) * $this->height;  //L * W * H
   }
   
   //calculate cubic feet
   private function cubicFeet()
   {
       return round($this->volumeInches() / (pow(12, 3)), 2);
   }
   
   //calculate chargeable weight
   private function chargeableWeightAir()
   {
       return round($this->volumeInches() / 166, 2);
   }
   
   
   //calculate final
   public function seaCalc(){
       
       //volume inches
       $this->volume = $this->volumeInches(); 
       
       //cubic feet
       $this->cobic_feet = $this->cubicFeet() < 3 ? 3 : $this->cubicFeet(); 
       
       //chargeable weight
       $this->chargeable_weight_air = $this->chargeableWeightAir(); 
       
       //sea shipping price
       $this->shipping_price = general_setting('freight')->sea_shipping_price;
       
       //sea insurance amount
       $this->insurance = general_setting('freight')->sea_insurance;
       
       //item value
       $this->item_value = $this->price + $this->insurance;
       
       //chargeable dimension amount
       $this->chargeable_dimension = $this->cobic_feet * $this->shipping_price;
       
       //insurance invoice value amount
       $this->insurance_invoice_value = ($this->insurance + $this->item_value);
       
       //clearance charge
       $this->clearance_charges = general_setting('freight')->sea_clearance_charges;
       
       //import duty
       $this->import_duty = (float) $this->getImportDutyData($this->import_duty)['value']; //get import duty value
       $this->import_duty = ($this->insurance_invoice_value * $this->import_duty) / 100;
       
       //OB
       $this->ob = (float) $this->ob;
       $this->ob = ($this->insurance_invoice_value * $this->ob) / 100;
       
       $this->total = ($this->insurance + $this->chargeable_dimension) + $this->clearance_charges + $this->import_duty + $this->ob;
       
       //return calculator info
       return [
           "cobic_feet" => $this->cobic_feet, 
           "chargeable_weight_air" => $this->chargeable_weight_air, 
           "price" => $this->price, 
           "insurance" => $this->insurance, 
           "item_value" => $this->item_value,
           "chargeable_dimension" => $this->chargeable_dimension,
           "insurance_invoice_value" => $this->insurance_invoice_value,
           "clearance_charges" => $this->clearance_charges,
           "import_duty" => $this->import_duty,
           "ob" => $this->ob,
           "total" => $this->total
       ];
   }

   function getImportDutyData($status = '0')
   {
       $import = ImportDuty::get();
       foreach($import as $key => $value){
           if($status == $key){
               return $value;
               break;
           }
       }
   }
}
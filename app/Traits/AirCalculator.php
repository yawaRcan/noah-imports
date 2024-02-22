<?php

namespace App\Traits;

use App\Models\Rate;
use App\Models\Currency;
use App\Models\ImportDuty;

/* 
|---------------------------------------------------
| Creating calculator Trait
|---------------------------------------------------
*/

trait AirCalculator
{
    //items
    public $item;
    public $import_duty;
    public $ob;
    public $weight;
    public $branch;
    public $length;
    public $width;
    public $height;
    public $discount_type;
    
    //outputs
    private $chargeable_weight_lbs; //weight in lbs
    private $item_value;
    private $custom_value;
    private $clearance_charges;
    private $total;
    private $grand_total;
    private $insurance;
    
    private $item_value_insurance;
    private $insurance_calculate;
    private $chargable_weight_final_amount; //weight value/amount
    private $chargable_weight_final_weight; //weight size
 

        //calculate chargeable weight
        public function chargeableWeight()
        {
            
            $this->chargeable_weight_lbs =  ceil( ($this->length * $this->width) * ($this->height) / 166);
            $this->weight = ceil($this->weight); 
            //IF actual weight is greather than or equal to chargeable weight, then return the actual weight as charge
            if($this->weight >= $this->chargeable_weight_lbs){
                //Actual weight rate
                
                return ['amount' => $this->getRatesData($this->weight,$this->branch)->amount, 'weight' => $this->weight]; 
            }
            elseif($this->chargeable_weight_lbs >= $this->weight){
                //Chargeable weight rate  
                return ['amount' => $this->getRatesData($this->chargeable_weight_lbs,$this->branch)->amount, 'weight' => $this->chargeable_weight_lbs];
            }
        }  

        //calculate final
        public function airCalc()
        {
            //chargeable total weight in lbs
            $this->chargable_weight_final_weight = $this->chargeableWeight()['weight']; 
            
            //Chargeable total weight amount
            $this->chargable_weight_final_amount = $this->chargeableWeight()['amount']; 
            
            //Insurance value
            $this->item_value_insurance =  (1 + $this->item); //item value insurance ($) - 1
            
            //convert to float
            
            $insurance_value = round((float) $this->getCurrency("USD")->value); 

            $clearance_charges = (float) general_setting('freight')->air_clearance_charges;
            
            //calculate insurance on item value of 100$
            $this->insurance_calculate = $this->divideIndex(100, $this->item); 
            $this->insurance = $this->insurance_calculate > 0 ? 
                    $this->insurance_calculate * $insurance_value : $insurance_value;
            
            //Item Value in ANG - 2
            $this->item_value = $this->item_value_insurance * $insurance_value; //1.82
            
            //Custom value in ANG - 3
            $this->custom_value = $this->item_value + $this->chargable_weight_final_amount; 
            
            //clearance charges - 4
            $this->clearance_charges = $clearance_charges; 
            
            //Import duty in ANG - 5
            
            if($this->import_duty){
                $this->import_duty = (float) $this->airImportDutyData($this->import_duty)->value;
                // dd($this->item_value_insurance,$insurance_value,$this->item_value,$this->custom_value,$this->import_duty); //get import duty value
                $this->import_duty = ( ($this->custom_value * $this->import_duty) / 100); 
            }
            
            
            //ob calculation
            $this->ob = (float) $this->ob;
            $this->ob = ( ($this->custom_value * $this->ob) / 100); 
            
            //calculate total and round
            $round = ($this->chargable_weight_final_amount + $this->clearance_charges) + ($this->import_duty + $this->ob);
            $this->total = ($round + $this->insurance); //round
            
            //calculate grand total
            $this->grand_total = round($this->total + $this->item);
            
            //return calculator info
            return [
                "insurance" => $this->insurance, 
                "item_value" => $this->item_value,
                "chargeable_weight_lbs" => $this->chargable_weight_final_weight,
                "chargeable_weight_amount" => $this->chargable_weight_final_amount,
                "custom_value" => $this->custom_value,
                "clearance_charges" => $this->clearance_charges,
                "import_duty" => $this->import_duty,
                "ob" => $this->ob,
                "total" => $this->total,
                "grand_total" => $this->grand_total
            ];
        }

    function getRatesData($weight = '0', $branch = '')
    { 
       
        $rates = Rate::where('branch_id',$branch)->get();
        $kg = null;
        foreach ($rates as $key => $value) {
             $kg = (float) $value->kg; 
            if ($weight == $kg ) { 
                
                return $value;
                break;
            }
        }  
           
            return Rate::where('branch_id',$branch)->first();
      
    }

    // function getRatesData($status = '0')
    // {
    //     $rates = Rate::get();
    //     foreach($rates as $key => $value){
    //         if($status == $key){
    //             return $value;
    //             break;
    //         }
    //     }
    // }

    function airImportDutyData($id = null)
{     
        if(isset($id)){
            $ImportDuty = ImportDuty::where('id',$id)->first(); 
            
            return $ImportDuty;
        } 
}

function divideIndex($index = 100, $amount = 0)
{
    $count = 0;
    for ($i = $index; $i <= $amount; $i++) 
    {  
        //execute if the index is excatly divided by itself without remender
        if( $i % $index === 0 ) {
          $count++;
        }  
    }
    
    return $count;
}

function getCurrency($currency = 'USD')
{
   
    if(isset($currency)){
        $currency = Currency::where('code',$currency)->first(); 
       
        return $currency;
    } 
}
 
}
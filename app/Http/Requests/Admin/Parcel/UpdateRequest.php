<?php

namespace App\Http\Requests\Admin\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [     
            "sender_ship_address" => "required|string", 
            "branch_id" => "required|string", 
            "from_country" => "required|string", 
            "to_country" => "required|string", 
            "external_shpper" => "required|string", 
            "freight_type" => "required|string", 
            "shipment_type" => "required|string", 
            "shipment_mode" => "required|string", 
            "quantity" => "required|string",  
            "dimention" => "required|string", 
            "weight" => "required|string", 
            "dimention" => "required|string", 
            "length_inch" => "required|string", 
            "width_inch" => "required|string", 
            "height_inch" => "required|string",  
            "product_desc" => "required|string", 
            "import_duties" => "required|string",    
            "discount" => "required|string", 
            "tax" => "required|string", 
            "external_tracking" => "required|string",  
            "estimate_delivery_date" => "required|string",  
            "comment" => "required|string",  
    ];
    }
}

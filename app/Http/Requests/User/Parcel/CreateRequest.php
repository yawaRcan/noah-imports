<?php

namespace App\Http\Requests\User\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
                "full_name" => "required|string",
                "reciver_ship_address" => "required|string",
                //"sender_ship_address" => "required|string", 
                //"branch_id" => "required|string", 
                // "from_country" => "required|string", 
                // "to_country" => "required|string", 
                "external_shpper" => "required|string", 
                "freight_type" => "required|string", 
                // "shipment_type" => "required|string", 
                // "shipment_mode" => "required|string", 
                "quantity" => "required|string",  
                "product_desc" => "required|string", 
                // "import_duties" => "required|string", 
                // "delivery_method" => "required|string",  
                "external_tracking" => "required|string", 
                "estimate_delivery_date" => "required|string", 
                "payment_method" => "required|string",   
                // "payment_file" => "required", 
                "comment" => "required|string",  
        ];
    }
}

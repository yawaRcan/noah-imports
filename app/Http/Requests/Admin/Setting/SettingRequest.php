<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            "waybil_no" => "required|string",
            "customer_no" => "required|string", 
            "referal_no" => "required|string", 
            "online_shop_invoice_address" => "required|string", 
            "user_page_view" => "required|string", 
            "admin_page_view" => "required|string", 
            "invoice_disclaimer" => "required|string", 
            "registration_disclaimer" => "required|string", 
            "calculator_disclaimer" => "required|string", 
            "shop_order_disclaimer" => "required|string", 
            "site_maintenance_disclaimer" => "required|string",  
        ];
    }
}

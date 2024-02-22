<?php

namespace App\Http\Requests\Admin\ParcelDelivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryRequest extends FormRequest
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
            "sign_image" => "required",
            "reciever_name" => "required",
            "delivered_by" => "required|numeric",
            // "parcel_image" => "required",
            "delivery_date" => "required",
        ];
        
    }
}

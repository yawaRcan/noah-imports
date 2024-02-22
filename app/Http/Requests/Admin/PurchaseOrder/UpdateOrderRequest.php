<?php

namespace App\Http\Requests\Admin\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'courier' => 'required|numeric',
            'delivery_status' => 'required|numeric',
            // 'invoice' => 'required',
            // 'awb' => 'required',
            'external_awb' => 'required',
            'tracking' => 'required',
            'payment_status' => 'required',
            // 'shipping_price' => 'required',
            // 'tax' => 'required' 
        ];
    }
}

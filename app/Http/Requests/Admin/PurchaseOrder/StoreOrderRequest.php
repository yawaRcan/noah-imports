<?php

namespace App\Http\Requests\Admin\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'purchase_id'=> 'required',
            'user_id'=> 'required|numeric',
            'shipping_address_id'=> 'required|numeric',
            // 'payment_method_id'=> 'required|numeric'
        ];
    }
}

<?php

namespace App\Http\Requests\User\Purchase;

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
            'purchase_id'=> 'required|numeric',
            'name'=> 'required',
            'size'=> 'required',
            'color'=> 'required',
            'quantity'=> 'required',
            'price'=> 'required',
            'shipping_price'=> 'required',
            'tax'=> 'required' 
        ];
    }
}

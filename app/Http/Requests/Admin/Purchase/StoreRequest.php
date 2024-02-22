<?php

namespace App\Http\Requests\Admin\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id'=> 'required|numeric',
            'name'=> 'required', 
            'website'=> 'required', 
            'quantity'=> 'required',
            'price'=> 'required',
            'shipping_price'=> 'required',
            'tax'=> 'required'
        ];
    }
}

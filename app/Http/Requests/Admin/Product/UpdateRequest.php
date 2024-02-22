<?php

namespace App\Http\Requests\Admin\Product;

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
            "category" => "required|string",
            "title" => "required|string", 
            "sub_category" => "required|string", 
            "size" => "required|string",
            "discount" => "required|string",
            "condition" => "required|string",
            "stock" => "required|string",
            "tax" => "required|string",
            "price" => "required|string",
            "shipping_price" => "required|string",
            // "summary" => "required|string",
            "product_desc" => "required|string",  
        ];
    }
}

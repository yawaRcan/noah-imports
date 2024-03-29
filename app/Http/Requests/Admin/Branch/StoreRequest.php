<?php

namespace App\Http\Requests\Admin\Branch;

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
            "name" => "required|string",
            "country" => "required|string",
            "state" => "required|string",
            "city" => "required|string",
            "contact_no" => "required|string",
            "address" => "required|string",
            "email" => "required|email",
            "currency_id" => "required|numeric",
            "pickup_fee" => "required|numeric",
        ];
    }
}

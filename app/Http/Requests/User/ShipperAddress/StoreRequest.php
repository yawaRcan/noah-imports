<?php

namespace App\Http\Requests\User\ShipperAddress;

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
            'country_id'=> 'required|numeric',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required',
            'contact_no'=> 'required',
            'address'=> 'required',
            'state'=> 'required',
            'city'=> 'string',
            'zipcode'=> 'required',
            'crib'=> 'required'
        ];
    }
}

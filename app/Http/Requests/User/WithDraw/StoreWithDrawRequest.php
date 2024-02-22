<?php

namespace App\Http\Requests\User\WithDraw;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithDrawRequest extends FormRequest
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
            'withdraw_amount'=> 'required',
        ];
    }
}

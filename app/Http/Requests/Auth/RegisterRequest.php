<?php

namespace App\Http\Requests\Auth;

use App\Models\User;

use Illuminate\Validation\Rules;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'contact_no' => ['required', 'numeric'],
            'country_id' => ['required', 'string'], 
            'email' => ['required', 'string', 'email', 'min:8', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'year' => ['required', 'string'],
            'month' => ['required', 'string'],
            'day' => ['required', 'string'],
        ];
    }
}

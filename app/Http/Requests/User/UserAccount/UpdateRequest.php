<?php

namespace App\Http\Requests\User\UserAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

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
        $formType = $this->input('formType');

        if($formType == 'account'){
            $id = $this->route()->parameter('id');
            return [
                'country_id'=> 'required|numeric',
                'first_name'=> 'required',
                'last_name'=> 'required',
                'customer_no'=> 'required',
                'company'=> 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                // 'username' => 'required|unique:users'.$id,
                'gender'=> 'required',
                'dob'=> 'required',
                'phone'=> 'required',
            ];
        }

        if($formType == 'privacy'){
            return [
                'timezone_id'=> 'required|numeric',
                'theme'=> 'required',
                'lang'=> 'required',
            ];
        }

        if($formType == 'change-password'){
            return [
                'password' => ['required', 'confirmed', Rules\Password::defaults()]
            ];
        }
        
    }
}

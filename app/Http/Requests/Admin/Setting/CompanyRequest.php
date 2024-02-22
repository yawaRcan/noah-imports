<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            "logo" => "file|mimes:png", 
            "favicon" => "file|mimes:png", 
            "watermark" => "file|mimes:png", 
            "invoice" => "file|mimes:png", 
            "online_shop" => "file|mimes:png", 
        ];
    }
}

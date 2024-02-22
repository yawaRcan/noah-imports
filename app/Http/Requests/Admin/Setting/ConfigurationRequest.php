<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
            "site_name" => "required|string",
            "store_name" => "required|string",
            "site_title" => "required|string",
            "site_description" => "required|string",
            "file_size" => "required|string",
            "default_currency" => "required|string",
            "default_lang" => "required|string",
        ];
    }
}

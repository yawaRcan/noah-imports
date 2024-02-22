<?php

namespace App\Http\Requests\Admin\ExternalShipper;

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
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        return [
            "name" => "required|string",
            "icon" => "required|file|mimes:jpg,png|between:20,2048",
            "link" => "required|regex:".$regex,
            "slug" => "required|string",
        ];
    }
}

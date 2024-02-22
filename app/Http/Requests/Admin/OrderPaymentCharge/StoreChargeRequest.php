<?php

namespace App\Http\Requests\Admin\OrderPaymentCharge;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Payment;

class StoreChargeRequest extends FormRequest
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
        $paymentMethod = Payment::findOrFail($this->input('payment_method'));
        if($paymentMethod->slug == "account-funds"){
            return [
                "paid_amount" => "required|numeric", 
                "payment_method" => "required|numeric", 
            ];
        }
        else{
            return [
                "paid_amount" => "required|numeric", 
                "payment_method" => "required|numeric", 
                'payment_receipt'=> 'required', 
            ];
        }
    }
}

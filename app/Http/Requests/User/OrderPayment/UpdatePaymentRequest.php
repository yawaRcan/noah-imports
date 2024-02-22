<?php

namespace App\Http\Requests\User\OrderPayment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Payment;

class UpdatePaymentRequest extends FormRequest
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
        $paymentMethod = Payment::findOrFail($this->input('payment_method_id'));
        if($paymentMethod->slug == "account-funds"){
            return [
                'shipping_address_id'=> 'required|numeric',
                'payment_method_id'=> 'required|numeric', 
            ];
        }
        else{
            return [
                'shipping_address_id'=> 'required|numeric',
                'payment_method_id'=> 'required|numeric',
                'payment_receipt'=> 'required', 
            ];
        }
    }
}

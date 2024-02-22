<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcommerceOrder extends Model
{
    use HasFactory;

     public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency() 
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function shipperAddress() 
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}

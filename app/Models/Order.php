<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\OrderObserver;

class Order extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(OrderObserver::class);
    }


    protected $casts = [
        'purchase_id' => 'array'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency() 
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function billing() 
    {
        return $this->hasMany(OrderPayment::class, 'order_id');
    }

    public function purchase() 
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function shipperAddress() 
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id');
    }

    public function deliveryStatus()
    {
        return $this->belongsTo(ConfigStatus::class, 'delivery_status');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function courierDetail()
    {
        return $this->belongsTo(ExternalShipper::class, 'courier');
    }
    
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}

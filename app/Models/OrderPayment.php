<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

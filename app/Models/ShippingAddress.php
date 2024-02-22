<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    public function morphable()
    {
        return $this->morphTo();
    }

    public function country() 
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

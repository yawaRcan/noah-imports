<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purchase_category_id',
        'currency_id',
        'name','size',
        'color','price',
        'quantity',
        'shipping_price',
        'tax',
        'description',
        'image_url',
        'product_url',
        'product_number',
        'website', 
    ];

    public function currency() 
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

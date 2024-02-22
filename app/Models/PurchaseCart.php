<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','purchase_id'];

    public function purchase() 
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateDiscount extends Model
{
    use HasFactory;
    protected $fillable = ['discount', 'user_id', 'items_id'];
}

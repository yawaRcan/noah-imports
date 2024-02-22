<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public function user() 
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function parent() 
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

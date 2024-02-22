<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','size','color','price','description'];
    
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'child_cat_id');
    }

    public function files()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class, 'product_tags','product_id','tag');
    }
}

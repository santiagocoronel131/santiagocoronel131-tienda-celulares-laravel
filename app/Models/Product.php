<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    public function category()
{
    return $this->belongsTo(Category::class);
}
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image_url'];
}

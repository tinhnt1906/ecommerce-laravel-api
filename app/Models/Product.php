<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable  = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'quantity',
        'status',
        'category_id',
    ];

    //1 product thuộc về 1 category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['order_id', 'product_id']);
    }
}

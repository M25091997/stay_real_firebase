<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mrp', 'price', 'food_category_id', 'food_sub_category_id', 'image', 'description', 'is_available', 'is_active'];

    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id', 'id');
    }

    public function foodSubCategory()
    {
        return $this->belongsTo(FoodSubCategory::class, 'food_sub_category_id');
    }
}

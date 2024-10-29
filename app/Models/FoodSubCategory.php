<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'food_category_id', 'image', 'desc', 'is_active'];

    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class, 'food_category_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image', 'desc', 'is_active'];

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}

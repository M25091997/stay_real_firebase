<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

    protected $fillable = ['check_in_id', 'booking_id', 'food_item_id', 'quantity', 'price'];

    public function checkIn()
    {
        return $this->belongsTo(CheckIn::class, 'check_in_id');
    }

    public function foodItem() {
        return $this->belongsTo(FoodItem::class, 'food_item_id');

    }
}

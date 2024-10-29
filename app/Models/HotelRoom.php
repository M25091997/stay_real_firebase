<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory;
    protected $fillable = ['room_status', 'room_category_id', 'room_sub_category_id', 'name', 'slug', 'number_of_beds', 'max_occupancy', 'cost_per_night', 'booking_price', 'is_available', 'image', 'subimage', 'description', 'other_info', 'amenity'];

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id', 'id');
    }

    public function roomSubCategory()
    {
        return $this->belongsTo(RoomSubCategory::class, 'room_sub_category_id');
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class, 'room_id');
    }
}

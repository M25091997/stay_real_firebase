<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;
    protected $fillable = ['booking_id', 'room_id', 'guest_id', 'persion', 'children', 'check_in_date', 'exp_check_out_date', 'check_out_date','advance_payment', 'notes', 'room_details', 'status'];

    // Define the relationship to the HotelRoom model
    public function hotelRoom()
    {
        return $this->belongsTo(HotelRoom::class, 'room_id');
    }

    // Define the relationship to the Guest model
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class, 'check_in_id');
    }


    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}

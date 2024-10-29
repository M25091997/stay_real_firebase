<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'check_in_id', 'guest_id', 'room_charges', 'food_charges', 'tax', 'total_amount','advance_payment', 'status', 'invoice_date', 'payment_method', 'payment_id', 'user_id'];


    public function checkIn()
    {
        return $this->belongsTo(CheckIn::class);
    }
}

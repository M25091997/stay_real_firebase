<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'check_in_date', 'check_out_date', 'status', 'gender', 'designation', 'organization', 'organization_address', 'residential_address', 'arrival_date', 'arrival_time', 'departure_date', 'departure_time', 'arrival_from', 'proceeding_to', 'purpose', 'dob', 'boa', 'nationality', 'passport_no', 'issue_date', 'expire_date', 'place_issue', 'type', 'registration_no', 'issue_date_reg', 'expire_date_reg', 'place_issue_reg', 'registration_type', 'arrival_date_india', 'duration', 'booked_by', 'payment_mode', 'tariff', 'document', 'id_card', 'persion', 'childern', 'state_id', 'city_id'];


    public function checkIns()
    {
        return $this->hasMany(CheckIn::class, 'guest_id');
    }
}

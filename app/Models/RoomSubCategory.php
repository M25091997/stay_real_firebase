<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'room_category_id', 'image', 'desc', 'is_active'];

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id');
    }
}

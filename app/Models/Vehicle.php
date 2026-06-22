<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name_vehicle', 
        'display_name'
    ];

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

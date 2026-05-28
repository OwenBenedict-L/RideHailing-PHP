<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'origin', 
        'destination', 
        'distance', 
        'fare', 
        'estimated_time', 
        'surge_multiplier', 
        'status'
    ];
}
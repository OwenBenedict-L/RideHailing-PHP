<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'discount_percentage',
        'max_discount',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'is_active' => 'boolean',
    ];
}
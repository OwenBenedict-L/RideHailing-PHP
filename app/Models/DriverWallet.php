<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id', 
        'balance',
        'bank_name',
        'bank_account_number'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function transactions()
    {
        return $this->hasMany(DriverWalletTransaction::class, 'driver_wallet_id');
    }
}

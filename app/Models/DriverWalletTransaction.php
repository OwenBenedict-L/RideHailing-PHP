<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['driver_wallet_id', 'type', 'amount', 'description'];

    public function wallet()
    {
        return $this->belongsTo(DriverWallet::class, 'driver_wallet_id');
    }
}

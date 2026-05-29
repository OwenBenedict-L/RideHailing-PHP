<?php

namespace App\Http\Controllers;

use App\Models\DriverWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverWalletController extends Controller
{
    public function index()
    {
        $driverId = Auth::id(); 
        $wallet = DriverWallet::firstOrCreate(
            ['driver_id' => $driverId],
            ['balance' => 0]
        );
        $balance = $wallet->balance;
        return view('wallet.driver-balance', compact('balance'));
    }
}

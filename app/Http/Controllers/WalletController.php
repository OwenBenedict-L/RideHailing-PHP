<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
        $balance = $wallet->balance;
        return view('wallet.balance', compact('balance'));
    }

    public function topupForm(){
        return view('wallet.topup');
    }

    public function processTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000'
        ]);
        $userId = Auth::id();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
        $wallet->balance += $request->amount;
        $wallet->save();
        return redirect()->route('wallet.balance')->with('success', 'Top Up with amount ' . 
        number_format($request->amount, 0, ',', '.') . ' successfully added!');
    }
}
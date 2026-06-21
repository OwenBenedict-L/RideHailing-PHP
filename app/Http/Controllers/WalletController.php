<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WalletTransaction;
use App\Models\UserNotification;

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
        ], [
            'amount.required' => 'Please enter the top up amount.',
            'amount.min' => 'The minimum top up amount is Rp1.000.'
        ]);
        $userId = Auth::id();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
        $wallet->balance += $request->amount;
        $wallet->save();

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'topup',
            'amount' => $request->amount,
            'description' => 'Top Up'
        ]);

        UserNotification::create([
            'user_id' => $userId,
            'type'    => 'wallet',
            'title'   => 'Top Up Successful!💵',
            'message' => 'An amount of Rp ' . number_format($request->amount, 0, ',', '.') . ' has been successfully credited to your wallet balance.',
            'is_read' => false
        ]);

        return redirect()->route('wallet.balance')->with('success', 'Top Up with amount Rp' . 
        number_format($request->amount, 0, ',', '.') . ' successfully added!');
    }

    public function history()
    {
        $userId = Auth::id();
        $wallet = Wallet::firstWhere('user_id', $userId);
        $transactions = $wallet ? $wallet->transactions()->latest()->get() : [];
        return view('wallet.history', compact('transactions'));
    }
}
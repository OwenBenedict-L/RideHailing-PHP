<?php

namespace App\Http\Controllers;

use App\Models\DriverWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DriverWalletTransaction;

class DriverWalletController extends Controller
{
    public function index()
    {
        $driverId = Auth::guard('driver')->id();
        $wallet = DriverWallet::firstOrCreate(
            ['driver_id' => $driverId],
            ['balance' => 0]
        );
        $balance = $wallet->balance;
        return view('wallet.driver-balance', compact('balance'));
    }

    public function withdrawForm()
    {
        $driverId = Auth::guard('driver')->id();
        $wallet = DriverWallet::firstOrCreate(
            ['driver_id' => $driverId],
            ['balance' => 0]
        );
        return view('wallet.driver-withdraw', compact('wallet'));
    }

    public function processWithdraw(Request $request)
    {
        $driverId = Auth::guard('driver')->id();
        $wallet = DriverWallet::firstWhere('driver_id', $driverId);
        $request->validate([
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|numeric',
            'amount' => 'required|numeric|min:10000|max:' . $wallet->balance 
        ], [
            'amount.max' => 'Insufficient balance for this withdrawal amount!',
            'amount.min' => 'The minimum withdrawal amount is Rp10.000.'
        ]);
        $wallet->balance -= $request->amount;
        $wallet->bank_name = $request->bank_name;
        $wallet->bank_account_number = $request->bank_account_number;
        $wallet->save();

        DriverWalletTransaction::create([
            'driver_wallet_id' => $wallet->id,
            'type' => 'withdraw',
            'amount' => $request->amount,
            'description' => 'Withdrawal to ' . $request->bank_name . ' (' . $request->bank_account_number . ')'
        ]);

        return redirect()->route('driver.wallet.balance')->with('success', 'Successfully withdrew Rp' .
        number_format($request->amount, 0, ',', '.') . ' to your ' . $request->bank_name . '!');
    }

    public function history()
    {
        Auth::guard('driver')->id();
        $wallet = DriverWallet::firstWhere('driver_id', $driverId);
        $transactions = $wallet ? $wallet->transactions()->latest()->get() : [];
        return view('wallet.driver-history', compact('transactions'));
    }
}

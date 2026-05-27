<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'driver'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination_location' => 'required|string|max:255',
            'promo_code' => 'nullable|string|max:50',
        ]);

        $distance = 5.0;
        $base_fare = 20000;
        $discount = 0;

        if ($request->filled('promo_code')) {
            if (strtoupper($request->promo_code) === 'UNTAR') {
                $discount = 5000;
            }
        }

        $total_fare = $base_fare - $discount;

        $userId = Auth::id();

        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );

        $wallet_balance = $wallet->balance;

        $balance_enough = $wallet_balance >= $total_fare;

        return view('bookings.checkout', [
            'pickup_location' => $request->pickup_location,
            'destination_location' => $request->destination_location,
            'promo_code' => $request->promo_code,
            'distance' => $distance,
            'fare' => $total_fare,
            'wallet_balance' => $wallet_balance,
            'balance_enough' => $balance_enough
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        if ($request->has('confirm_booking')) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'pickup_location' => $request->pickup_location,
                'destination_location' => $request->destination_location,
                'promo_code' => $request->promo_code,
                'fare' => $request->fare,
                'distance' => $request->distance,
                'status' => 'pending'
            ]);

            $wallet = Wallet::where('user_id', Auth::id())->first();
            if ($wallet) {
                $wallet->balance -= $request->fare;
                $wallet->save();
            }

            return redirect()->route('bookings.index')->with('success', 'Booking successful! Finding your driver...');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,on_way,completed,cancelled',
        ]);

        $data = $request->only('status');

        if ($request->status === 'confirmed') {
        $data['driver_id'] = Auth::guard('driver')->id(); 
        } else {
        $data['driver_id'] = $booking->driver_id;
        }

        $booking->update($data);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
    }
}

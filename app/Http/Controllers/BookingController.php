<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\Promo;
use App\Models\UserNotification;
use App\Models\WalletTransaction;
use App\Models\DriverWallet;
use App\Models\DriverWalletTransaction;
use App\Models\DriverNotification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'driver'])
            ->where('user_id', Auth::guard('user')->id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeBooking = Booking::where('user_id', Auth::guard('user')->id())
            ->whereIn('status', ['pending', 'confirmed', 'on_way'])
            ->first();

        if ($activeBooking) {
            return redirect()->route('bookings.index')->with('error', 'You cannot book a new ride until your current trip is completed or cancelled!');
        }

        session()->flashInput(request()->old());

        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('confirm_booking')) {
        $booking = Booking::create([
            'user_id' => Auth::guard('user')->id(),
            'pickup_location' => $request->pickup_location,
            'destination_location' => $request->destination_location,
            'promo_code' => $request->promo_code,
            'vehicle_type_id' => session('checkout_vehicle_type_id'),
            'fare' => $request->fare,
            'distance' => $request->distance,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking successful! Finding your driver...');
        }

        $userId = Auth::guard('user')->id();

        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );

        $total_fare = $request->fare;
        $discount_amount = 0;

        if ($request->promo_code) {
            $promo = Promo::where('code', strtoupper($request->promo_code))->first();

            if ($promo && $promo->expiry_date >= now() && $promo->is_active) {
                $discount_amount = ($promo->discount_percentage / 100) * $total_fare;

                if ($promo->max_discount && $discount_amount > $promo->max_discount) {
                    $discount_amount = $promo->max_discount;
                }
            }
        }

        $final_fare = $total_fare - $discount_amount;
        $balance_enough = $wallet->balance >= $final_fare;

        return view('bookings.checkout', [
            'pickup_location' => $request->pickup_location,
            'destination_location' => $request->destination_location,
            'promo_code' => $request->promo_code,
            'distance' => $request->distance ?? 0,
            'original_fare' => $total_fare,
            'discount_amount' => $discount_amount,
            'fare' => $final_fare,
            'wallet_balance' => $wallet->balance,
            'balance_enough' => $balance_enough
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::guard('user')->id()) {
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
        $request->validate([
            'status' => 'required|in:pending,confirmed,on_way,completed,cancelled',
        ]);

        $isDriver = Auth::guard('driver')->check();
        $data = $request->only('status');

        if ($request->status === 'confirmed') {
        $data['driver_id'] = Auth::guard('driver')->id(); 
        } else {
        $data['driver_id'] = $booking->driver_id;
        }

        $booking->update($data);

        if ($request->status === 'on_way') {
            UserNotification::create([
                'user_id' => $booking->user_id,
                'type' => 'ride',
                'title' => 'Trip Started ➔',
                'message' => 'Your trip to ' . $booking->destination_location . ' has started!',
                'is_read' => false
            ]);

            if ($booking->driver_id) {
                    DriverNotification::create([
                        'driver_id' => $booking->driver_id,
                        'type' => 'ride',
                        'title' => 'Trip Started ➔',
                        'message' => 'You have started the trip. Please drive safely to ' . $booking->destination_location . '.',
                        'is_read' => false
                    ]);
                }

        } elseif ($request->status === 'completed') {
            $wallet = Wallet::where('user_id', $booking->user_id)->first();
            if ($wallet) {
                $wallet->balance -= $booking->fare;
                $wallet->save();

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'payment',
                    'amount' => $booking->fare,
                    'description' => 'Paid for Trip #' . $booking->id
                ]);
            }

            if ($booking->driver_id) {
                $driverWallet = DriverWallet::firstOrCreate(
                    ['driver_id' => $booking->driver_id],
                    ['balance' => 0]
                );

                $driverWallet->balance += $booking->fare;
                $driverWallet->save();

                DriverWalletTransaction::create([
                    'driver_wallet_id' => $driverWallet->id,
                    'type' => 'earnings',
                    'amount' => $booking->fare,
                    'description' => 'Earnings from Trip #' . $booking->id
                ]);

                DriverNotification::create([
                    'driver_id' => $booking->driver_id,
                    'type' => 'wallet',
                    'title' => 'Trip Completed!💰',
                    'message' => 'You have successfully completed Trip #' . $booking->id . '. Earnings of Rp ' . number_format($booking->fare, 0, ',', '.') . ' have been added to your wallet.',
                    'is_read' => false
                ]);
            }

            UserNotification::create([
                'user_id' => $booking->user_id,
                'type' => 'ride',
                'title' => 'Trip Completed 🥳',
                'message' => 'You have arrived at ' . $booking->destination_location . '. Thank you for riding with us! ',
                'is_read' => false
            ]);

            DriverNotification::create([
                'driver_id' => Auth::guard('driver')->id(),
                'type' => 'ride',
                'title' => 'Order Confirmed 👨🏻‍✈️',
                'message' => 'You have accepted Trip #' . $booking->id . '. Please pick up ' . $booking->user->name . ' at ' . $booking->pickup_location . '.',
                'is_read' => false
            ]);
        }

        if($isDriver) {
            return redirect()->route('driver.orders')->with('success', 'Order status has been updated successfully.');
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Driver Management Functions.
     */
    public function driverOrders()
    {
        if (!Auth::guard('driver')->check()) {
            abort(403, 'Unauthorized action. Only drivers can access this page.');
        }

        $driverId = Auth::guard('driver')->id();
        $driver = Auth::guard('driver')->user();
        $rejectedOrders = session()->get('rejected_orders', []);

        $orders = Booking::with('user')
            ->where('vehicle_type_id', $driver->vehicle_type_id)
            ->whereNotIn('id', $rejectedOrders)
            ->where(function($query) use ($driverId) {
                $query->where('status', 'pending')
                ->orWhere('driver_id', $driverId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.orders', compact('orders'));
    }

    public function acceptOrder(Booking $booking)
    {
        if (!Auth::guard('driver')->check()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Sorry, this order has already been taken by another driver or was cancelled.');
        }

        $booking->update([
            'driver_id' => Auth::guard('driver')->id(),
            'status' => 'confirmed'
        ]);

        UserNotification::create([
            'user_id' => $booking->user_id,
            'type' => 'ride',
            'title' => 'Driver Found!👨🏻‍✈️',
            'message' => 'Your driver, ' . Auth::guard('driver')->user()->name . ' (' . Auth::guard('driver')->user()->license_plate . '), is on the way to pick you up at ' . $booking->pickup_location . '.',
            'is_read' => false
        ]);

        return redirect()->route('driver.orders')->with('success', 'Order successfully accepted! Please pick up the passenger.');
    }

    public function rejectOrder(Booking $booking)
    {
        if (!Auth::guard('driver')->check()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Sorry, this order has already been taken by another driver or was cancelled.');
        }

        $rejectedOrders = session()->get('rejected_orders', []);
    
        if (!in_array($booking->id, $rejectedOrders)) {
            $rejectedOrders[] = $booking->id;
            session()->put('rejected_orders', $rejectedOrders);
        }

        return redirect()->route('driver.orders')->with('success', 'Order successfully skipped.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->status === 'pending' || $booking->status === 'confirmed') {

            $oldDriverId = $booking->driver_id;

            $booking->update([
                'status' => 'cancelled'
            ]);

            UserNotification::create([
                'user_id' => $booking->user_id,
                'type' => 'ride',
                'title' => 'Trip Cancelled by Driver ❌',
                'message' => 'Your booking to ' . $booking->destination_location . ' has been cancelled.',
                'is_read' => false
            ]);

            if ($oldDriverId) {
                DriverNotification::create([
                    'driver_id' => $oldDriverId,
                    'type'      => 'ride',
                    'title'     => 'Trip Cancelled by Passenger ❌',
                    'message'   => 'Trip #' . $booking->id . ' to ' . $booking->destination_location . ' has been cancelled by the passenger.',
                    'is_read'   => false
                ]);

                return redirect()->route('driver.orders')->with('success', 'Your ride has been successfully cancelled.');
            }

            return redirect()->route('bookings.index')->with('success', 'Your ride has been successfully cancelled.');   
        }
    }
}

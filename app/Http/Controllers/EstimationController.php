<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Estimation; 
use Illuminate\Support\Facades\Auth;

class EstimationController extends Controller
{
    public function create()
    {
        return view('estimations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'destination_location' => 'required|string',
        ]);

        $distance = rand(2, 15);
        $tarifMotor = $distance * 5000; 
        $surgeMultiplier = rand(95, 105) / 100;
        $fareAkhir = $tarifMotor * $surgeMultiplier;

        $waktuEstimasi = round(($distance / 40) * 60);


        $estimation = Estimation::create([
            'user_id' => Auth::id(),
            'origin' => $request->pickup_location,
            'destination' => $request->destination_location,
            'distance' => $distance,
            'fare' => $fareAkhir,
            'estimated_time' => $waktuEstimasi,
            'surge_multiplier' => $surgeMultiplier,
            'status' => 'ACTIVE' 
        ]);
        session(['current_estimation_id' => $estimation->id]);
        return redirect()->route('estimations.show');
    }

    public function show()
    {
        $id = session('current_estimation_id');
        if (!$id) {
            return redirect()->route('estimations.create')->with('error', 'Silakan buat rute estimasi terlebih dahulu.');
        }
        $estimation = Estimation::findOrFail($id);
        return view('estimations.show', compact('estimation'));
    }

    public function selectVehicle(Request $request)
    {
        $estimationId = $request->input('estimation_id');
        $estimation = Estimation::findOrFail($estimationId);

        if ($request->vehicle_type === 'Car') {
            $hargaMobil = $estimation->distance * 5000;
            $estimation->update([
                'fare' => $hargaMobil
            ]);
        }

        session(['checkout_estimation_id' => $estimation->id]);

        return redirect()->route('bookings.checkout');
    }

    public function checkout()
    {
        $estimationId = session('checkout_estimation_id');

        if (!$estimationId) {
            return redirect('/estimations')->with('error', 'Data estimasi tidak ditemukan.'); 
        }

        $estimation = Estimation::findOrFail($estimationId);

        $pickup_location = $estimation->origin;
        $destination_location = $estimation->destination;
        $distance = $estimation->distance;

        $original_fare = $estimation->fare;
        $discount_amount = 0; 
        $fare = $original_fare - $discount_amount;

        $promo_code = null; 

        $wallet = Wallet::where('user_id', auth()->id())->first();

        $wallet_balance = $wallet ? $wallet->balance : 0;

        $balance_enough = $wallet_balance >= $fare;

        return view('bookings.checkout', compact(
            'estimation', 
            'pickup_location', 
            'destination_location', 
            'distance', 
            'original_fare', 
            'discount_amount', 
            'fare',
            'promo_code',
            'wallet_balance',
            'balance_enough'
        )); 
    }
}
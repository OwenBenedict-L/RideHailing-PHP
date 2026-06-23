<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Estimation; 
use App\Models\Vehicle;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EstimationController extends Controller
{
    public function create(){
    
    $id = session('current_estimation_id');
        if ($id) {
            $estimation = Estimation::find($id);
            if ($estimation) {
                session()->flashInput([
                    'pickup_location'      => $estimation->origin,
                    'destination_location' => $estimation->destination,
                ]);
            }
        }
        
            return view('bookings.create');
    }

 public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'destination_location' => 'required|string',
        ]);

        session(['checkout_promo_code' => $request->promo_code]);

        $userId = Auth::id() ?? session()->getId();

        $currentEstimationId = session('current_estimation_id');
        $estimation = null;

        if ($currentEstimationId) {
            $estimation = Estimation::find($currentEstimationId);
        }

        if ($estimation && $estimation->origin === $request->pickup_location && $estimation->destination === $request->destination_location) {

            return redirect()->route('estimations.show');
        }

        $distance = rand(2, 15); 
        $tarifMotor = $distance * 5000; 
        
        $surgeMultiplier = Cache::remember('surge_motor_' . $userId, now()->addHour(), function () {
            return rand(95, 105) / 100;
        });
        
        $fareAkhir = $tarifMotor * $surgeMultiplier;
        $waktuEstimasi = round(($distance / 40) * 60);

        if ($estimation) {
            $estimation->update([
                'user_id' => Auth::id(),
                'origin' => $request->pickup_location,
                'destination' => $request->destination_location,
                'distance' => $distance,
                'fare' => $fareAkhir,
                'estimated_time' => $waktuEstimasi,
                'surge_multiplier' => $surgeMultiplier,
                'status' => 'ACTIVE' 
            ]);
        } else {
            // Jika benar-benar baru, create
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
        }

        return redirect()->route('estimations.show');
    }

    public function show()
    {
        $id = session('current_estimation_id');
        if (!$id) {
            return redirect()->route('estimations.create')->with('error', 'Silakan buat rute estimasi terlebih dahulu.');
        }
        $estimation = Estimation::findOrFail($id);
        $vehicleTypes = Vehicle::all();

        $fares = [];
        foreach($vehicleTypes as $vehicle) {
            if (strtolower($vehicle->name_vehicle) === 'car') {
                $hargaAwalMobil = $estimation->distance * 5000;
                $surgeMobil = rand(120, 130) / 100;
                $fares[$vehicle->id] = $hargaAwalMobil * $surgeMobil;
            } else {
                $fares[$vehicle->id] = $estimation->fare; 
            }
        }

        session(['calculated_fares' => $fares]);
        
        return view('estimations.show', compact('estimation', 'vehicleTypes', 'fares'));
    }

    public function selectVehicle(Request $request)
    {
        $request->validate([
            'estimation_id' => 'required|exists:estimations,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id'
        ]);

        $estimationId = $request->input('estimation_id');
        $estimation = Estimation::findOrFail($estimationId);
        $vehicleType = Vehicle::findOrFail($request->input('vehicle_type_id'));

        $fares = session('calculated_fares');
        $finalFare = $fares[$vehicleType->id] ?? $estimation->fare;
        
        $estimation->update(['fare' => $finalFare]);

        session([
            'checkout_estimation_id' => $estimation->id,
            'checkout_vehicle_type_id' => $vehicleType->id 
        ]);

        return redirect()->route('bookings.checkout');
    }

    public function checkout()
    {
        $estimationId = session('checkout_estimation_id');
        $vehicleTypeId = session('checkout_vehicle_type_id');
        $promo_code = session('checkout_promo_code');

        if (!$estimationId || !$vehicleTypeId) {
            return redirect('/estimations')->with('error', 'Data estimasi tidak ditemukan.'); 
        }

        $estimation = Estimation::findOrFail($estimationId);

        $pickup_location = $estimation->origin;
        $destination_location = $estimation->destination;
        $distance = $estimation->distance;

        $original_fare = $estimation->fare;
        $discount_amount = 0; 

        if ($promo_code) {
            $promo = Promo::where('code', strtoupper($promo_code))->first();
            if ($promo && $promo->expiry_date >= now() && $promo->is_active) {
                $discount_amount = ($promo->discount_percentage / 100) * $original_fare;
                if ($promo->max_discount && $discount_amount > $promo->max_discount) {
                    $discount_amount = $promo->max_discount;
                }
            }
        }

        $fare = $original_fare - $discount_amount;

        $wallet = Wallet::where('user_id', auth()->id())->first();

        $wallet_balance = $wallet ? $wallet->balance : 0;

        $balance_enough = $wallet_balance >= $fare;

        return view('bookings.checkout', compact(
            'estimation', 
            'pickup_location', 
            'destination_location',
            'vehicleTypeId',
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
<?php

namespace App\Http\Controllers;

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

        return redirect()->route('estimations.show', $estimation->id);
    }

    public function show($id)
    {
        $estimation = Estimation::findOrFail($id);
        return view('estimations.show', compact('estimation'));
    }

    public function selectVehicle(Request $request, $id)
    {
        $estimation = Estimation::findOrFail($id);
    
        if ($request->vehicle_type === 'Car') {
            $hargaMobil = $estimation->distance * 5000;
            $estimation->update([
                'fare' => $hargaMobil
            ]);
        }

        return redirect()->route('bookings.checkout', $estimation->id);
    }

    public function checkout($id)
    {
        // 1. Ambil data koper besar
        $estimation = Estimation::findOrFail($id);
        
        // 2. Variabel eceran untuk rute dan jarak
        $pickup_location = $estimation->origin;
        $destination_location = $estimation->destination;
        $distance = $estimation->distance;
        
        // 3. Variabel eceran untuk harga dan promo
        $original_fare = $estimation->fare;
        $discount_amount = 0; 
        $fare = $original_fare - $discount_amount;
        
        // TAMBAHAN BARU: Variabel untuk Promo Code (diisi null dulu jika belum ada sistem validasi promo)
        $promo_code = null; 

        // TAMBAHAN BARU: Variabel untuk Saldo (Wallet)
        // Kita gunakan auth()->user() untuk mengambil saldo user yang sedang login
        $wallet_balance = auth()->user()->wallet_balance ?? 0;
        
        // TAMBAHAN BARU: Pengecekan apakah saldo cukup (menghasilkan nilai True/False)
        $balance_enough = $wallet_balance >= $fare;

        // 4. Kirim SEMUA variabel yang diminta ke halaman web
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
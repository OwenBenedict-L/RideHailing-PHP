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
        // 1. Validasi Input
        $request->validate([
            'pickup_location' => 'required|string',
            'destination_location' => 'required|string',
        ]);

        // 2. Perhitungan (Bisa disesuaikan dengan kebutuhan demo Anda)
        $distance = rand(2, 15);
        $fare = $distance * 5000; 
        
        // Menghitung estimasi waktu (Asumsi kecepatan rata-rata 40 km/jam)
        $waktuEstimasi = round(($distance / 40) * 60);

        // 3. Simpan ke Database
        $estimation = Estimation::create([
            'user_id' => Auth::id(),
            'origin' => $request->pickup_location,
            'destination' => $request->destination_location,
            'distance' => $distance,
            'fare' => $fare,
            'estimated_time' => $waktuEstimasi, // Laci ini sekarang terisi!
            'surge_multiplier' => 1.0,          // Nilai default
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
            $hargaMobil = $estimation->distance * 6500;
            $estimation->update([
                'fare' => $hargaMobil
            ]);
        }

        return redirect()->route('estimations.confirmation', $estimation->id);
    }

    public function confirmation($id)
    {
        $estimation = Estimation::findOrFail($id);
        return view('estimations.dashboard', compact('estimation'));
    }
}
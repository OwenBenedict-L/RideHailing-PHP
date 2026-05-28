<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estimation; 
use Illuminate\Support\Facades\Auth;

class EstimationController extends Controller
{
    public function create()
    {
        // Menampilkan halaman form input lokasi
        return view('estimations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'destination_location' => 'required|string',
        ]);

        $distance = rand(2, 15);
        $fare = $distance * 5000; 
        
        $estimation = Estimation::create([
            'user_id' => Auth::id(),
            'origin' => $request->pickup_location,
            'destination' => $request->destination_location,
            'distance' => $distance,
            'fare' => $fare,
            'status' => 'ACTIVE' 
        ]);

        return redirect()->route('estimations.show', $estimation->id);
    }

    public function show($id)
    {
        $estimation = Estimation::findOrFail($id);
        return view('estimations.dashboard', compact('estimation'));
    }
}
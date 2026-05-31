<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::where('is_active', true)
            ->where('expiry_date', '>=', now())
            ->get();

        return response()->json($promos);
    }

    public function create()
    {
        if (Auth::user()->email !== 'developer@gmail.com') {
            abort(403);
        }

        return view('promos.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->email !== 'developer@gmail.com') {
            abort(403);
        }

        Promo::create([
            'code' => strtoupper($request->code),
            'discount_percentage' => $request->discount_percentage,
            'max_discount' => $request->max_discount,
            'expiry_date' => $request->expiry_date,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Promo successfully created!');
    }

    public function validatePromo(Request $request)
    {
        $promo = Promo::where('code', strtoupper($request->code))->first();

        if (!$promo || $promo->expiry_date < now() || !$promo->is_active) {
            return response()->json(['error' => 'Invalid promo'], 400);
        }

        $discount_amount = ($promo->discount_percentage / 100) * $request->fare;

        if ($promo->max_discount && $discount_amount > $promo->max_discount) {
            $discount_amount = $promo->max_discount;
        }

        return response()->json([
            'original_fare' => $request->fare,
            'discount_amount' => $discount_amount,
            'final_fare' => $request->fare - $discount_amount
        ]);
    }

    public function destroy($id)
    {
        Promo::destroy($id);
        return response()->json(['message' => 'Promo deleted']);
    }
}
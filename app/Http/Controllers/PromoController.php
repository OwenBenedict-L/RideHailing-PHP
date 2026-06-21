<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
public function index()
    {
        if (Auth::user()->email === 'developer@gmail.com') {
            $promos = Promo::all();
        } else {
            $promos = Promo::where('is_active', true)
                ->where('expiry_date', '>=', now())
                ->get();
        }

        return view('promos.index', ['promos' => $promos]);
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

        if ($request->discount_percentage < 1 || $request->discount_percentage > 100) {
            return redirect()->back()->with('error', 'Discount percentage must be between 1 and 100!');
        }

        $existing_promo = Promo::where('code', strtoupper($request->code))->first();
        if ($existing_promo) {
            return redirect()->back()->with('error', 'Promo code already exists!');
        }

        $promo = Promo::create([
            'code' => strtoupper($request->code),
            'discount_percentage' => $request->discount_percentage,
            'max_discount' => $request->max_discount,
            'expiry_date' => $request->expiry_date,
            'is_active' => true,
        ]);

        $users = User::all();
        foreach ($users as $user) {
            UserNotification::create([
                'user_id' => $user->id,
                'type'    => 'promo',
                'title'   => 'Special Promo Available! 🎁',
                'message' => 'Get a ' . $request->discount_percentage . '% discount on your ride using promo code: [' . $promo->code . ']. Valid until ' . \Carbon\Carbon::parse($request->expiry_date)->format('d M Y') . '!',
                'is_read' => false
            ]);
        }

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
        if (Auth::user()->email !== 'developer@gmail.com') {
            abort(403);
        }

        Promo::destroy($id);
        
        return redirect()->back()->with('success', 'Promo deleted successfully!');
    }
}
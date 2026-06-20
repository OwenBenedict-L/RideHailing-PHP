<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('bookings.index')->with('error', 'Only completed trips can be reviewed.');
        }

        if ($booking->review) {
            return redirect()->route('bookings.index')->with('error', 'You have already reviewed this trip.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'driver_id' => $booking->driver_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('bookings.index')->with('success', 'Review submitted!');
    }

    public function edit($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        $review = $booking->review;

        if (!$review || $review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('reviews.edit', compact('booking', 'review'));
    }

    public function update(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $review = $booking->review;

        if (!$review || $review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('bookings.index')->with('success', 'Review updated successfully!');
    }
}

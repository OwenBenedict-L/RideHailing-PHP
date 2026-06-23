<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Ride App</title>
    @vite(['resources/css/booking-checkout.css'])
</head>
<body>

<div class="card">

    <button type="button" class="back-link" onclick="window.history.back();">
        &larr; BACK
    </button>

    <h1>Booking Confirmation</h1>

    <h3>Trip Route</h3>
    <p><strong>Pickup Location:</strong> {{ $pickup_location }}</p>
    <p><strong>Destination Location:</strong> {{ $destination_location }}</p>
    <p><strong>Estimated Distance:</strong> {{ $distance }} Km</p>

    <hr>

    <h3>Fare Details</h3>
    @if($discount_amount > 0)
        <p>Original Fare: <strike>Rp {{ number_format($original_fare, 0, ',', '.') }}</strike></p>
        <p style="color: green;">Promo Discount: - Rp {{ number_format($discount_amount, 0, ',', '.') }}</p>
    @endif
    <p>Total Fare: <strong>Rp {{ number_format($fare, 0, ',', '.') }}</strong></p>
    @if($promo_code)
        <p>Promo Code Applied: <span style="color: green;">{{ strtoupper($promo_code) }}</span></p>
    @endif

    <hr>

    <h3>Your Wallet</h3>
    <p>Balance: Rp {{ number_format($wallet_balance, 0, ',', '.') }}</p>

    @if($balance_enough)
        <p style="color: green; font-weight: bold;">You're all set! Balance is enough for this trip.</p>
        
        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="confirm_booking" value="1">
            <input type="hidden" name="pickup_location" value="{{ $pickup_location }}">
            <input type="hidden" name="destination_location" value="{{ $destination_location }}">
            <input type="hidden" name="promo_code" value="{{ $promo_code }}">
            <input type="hidden" name="fare" value="{{ $fare }}">
            <input type="hidden" name="distance" value="{{ $distance }}">
            
            <button type="submit" class="btn-primary">BOOK NOW</button>
        </form>
    @else
        <p style="color: red; font-weight: bold;">Not enough balance. Please go back to the main dashboard to top up your wallet first.</p>
        
        <button type="button" class="btn-disabled" disabled>BOOK NOW</button>
    @endif

</div>

</body>
</html>
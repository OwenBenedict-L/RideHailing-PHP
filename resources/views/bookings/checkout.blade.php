<h1>Booking Confirmation</h1>

<h3>Trip Route</h3>
<p><strong>Pickup Location:</strong> {{ $pickup_location }}</p>
<p><strong>Destination Location:</strong> {{ $destination_location }}</p>
<p><strong>Estimated Distance:</strong> {{ $distance }} Km</p>

<hr>

<h3>Fare Details</h3>
<p>Total Fare: <strong>Rp {{ number_format($fare, 0, ',', '.') }}</strong></p>
@if($promo_code)
    <p>Promo Code Applied: <span style="color: green;">{{ strtoupper($promo_code) }}</span></p>
@endif

<hr>

<h3>Your Wallet</h3>
<p>Balance: Rp {{ number_format($wallet_balance, 0, ',', '.') }}</p>

@if($balance_enough)
    <p style="color: green; font-weight: bold;">You're all set! Balance is enough for this trip.</p>
    
    <form method="POST" action="{{ route('bookings.update', 0) }}">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="confirm_booking" value="1">
        <input type="hidden" name="pickup_location" value="{{ $pickup_location }}">
        <input type="hidden" name="destination_location" value="{{ $destination_location }}">
        <input type="hidden" name="promo_code" value="{{ $promo_code }}">
        <input type="hidden" name="fare" value="{{ $fare }}">
        <input type="hidden" name="distance" value="{{ $distance }}">
        
        <a href="{{ route('bookings.create') }}"><button type="button">CHANGE ROUTE</button></a>
        <button type="submit" style="background-color: green; color: white; padding: 10px;">BOOK NOW</button>
    </form>
@else
    <p style="color: red; font-weight: bold;">Not enough balance. Please top up your wallet.</p>
    <a href="{{ route('bookings.create') }}"><button type="button">BACK</button></a>
    <button type="button" disabled style="background-color: grey; color: white; padding: 10px;">BOOK NOW</button>
@endif

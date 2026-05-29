<!DOCTYPE html>
<html>
<body>
    <h2>Booking Confirmation</h2>
    <hr>
    
    <h3>Trip Route</h3>
    <p><strong>Pickup Location:</strong> {{ $estimation->origin }}</p>
    <p><strong>Destination Location:</strong> {{ $estimation->destination }}</p>
    <p><strong>Estimated Distance:</strong> {{ $estimation->distance }} Km</p>
    
    <hr>
    <h3>Fare Details</h3>
    <p><strong>Total Fare:</strong> Rp {{ number_format($estimation->fare, 0, ',', '.') }}</p>
    
    <hr>
    <h3>Your Wallet</h3>
    <p>Balance: Rp {{ number_format(Auth::user()->wallet_balance ?? 0, 0, ',', '.') }}</p>

    @if(session('error'))
        <p style="color: red;"><b>{{ session('error') }}</b></p>
    @endif

    <hr>
    <form action="{{ route('bookings.confirm') }}" method="POST">
        @csrf
        <input type="hidden" name="estimation_id" value="{{ $estimation->id }}">
        
        <label>Promo Code (Optional):</label><br>
        <input type="text" name="promo_code" placeholder="Example: UNTAR">
        <br><br>
        
        <button type="button" onclick="window.history.back();">BACK</button>
        <button type="submit">BOOK NOW</button>
    </form>
</body>
</html>

@if (session('success'))
    <p>{{ session('success') }}</p>
    <hr>
@endif
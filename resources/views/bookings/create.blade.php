<html>
<body>
<h1>Book Your Ride</h1>

<form method="POST" action="{{ route('estimations.store') }}">
    @csrf
    
    Pickup Location:
    <br>
    <input name="pickup_location" value="{{ request('pickup_location') }}" placeholder="Enter pickup location" required>
    <br><br>
    
    Destination Location:
    <br>
    <input name="destination_location" value="{{ request('destination_location') }}" placeholder="Enter destination location" required>
    <br><br>

    Promo Code (Optional):
    <br>
    <input name="promo_code" value="{{ request('promo_code') }}" placeholder="Example: UNTAR">
    <br><br>
    
    <a href="/bookings"><button type="button">BACK</button></a>
    <button type="submit">NEXT</button>
</form>
</body>
</html>

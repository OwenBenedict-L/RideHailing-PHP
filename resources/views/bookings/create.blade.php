<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Ride - Ride App</title>
    @vite(['resources/css/booking-create.css'])
</head>
<body>

<div class="card">
    
    <a href="{{ url('/bookings') }}" class="back-link">&larr; BACK</a>

    <h1>Book Your Ride</h1>

    <form method="POST" action="{{ route('estimations.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="pickup_location">Pickup Location</label>
            <input type="text" id="pickup_location" name="pickup_location" value="{{ old('pickup_location', request('pickup_location')) }}" placeholder="Enter pickup location" required>
        </div>

        <div class="form-group">
            <label for="destination_location">Destination Location</label>
            <input type="text" id="destination_location" name="destination_location" value="{{ old('destination_location', request('destination_location')) }}" placeholder="Enter destination location" required>
        </div>

        <div class="form-group">
            <label for="promo_code">Promo Code (Optional)</label>
            <input type="text" id="promo_code" name="promo_code" value="{{ old('promo_code', session('checkout_promo_code')) }}" placeholder="Example: UNTAR">
        </div>

        <button type="submit" class="btn-primary">NEXT</button>
    </form>

</div>

</body>
</html>
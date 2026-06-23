<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Estimations</title>
    @vite(['resources/css/estimations.css'])
</head>
<body>

    <div class="card">
        
        <h1>Ride Estimations</h1>
        <hr>

        <p><strong>{{ $estimation->origin }} &rarr; {{ $estimation->destination }}</strong></p>
        <p>Distance: {{ $estimation->distance }} Km</p>

        <h3>Available Vehicles</h3>
        
        <form action="{{ route('estimations.selectVehicle') }}" method="POST">
            @csrf
            <input type="hidden" name="estimation_id" value="{{ $estimation->id }}">
            
            <input type="hidden" name="pickup_location" value="{{ $estimation->origin }}">
            <input type="hidden" name="destination_location" value="{{ $estimation->destination }}">
            <input type="hidden" name="distance" value="{{ $estimation->distance }}">
            <input type="hidden" name="promo_code" value="{{ request('promo_code') ?? session('checkout_promo_code') }}">

            <div class="vehicle-options">
                @if(isset($vehicleTypes) && $vehicleTypes->count() > 0)
                    @foreach($vehicleTypes as $index => $vehicle)
                    <label class="vehicle-card">
                        <input type="radio" name="vehicle_type_id" value="{{ $vehicle->id }}" {{ $index == 0 ? 'checked' : '' }} required>
                        <div class="vehicle-details">
                            <span class="vehicle-name">{{ $vehicle->display_name }}</span>
                            <span class="vehicle-fare">Fare: Rp {{ number_format($fares[$vehicle->id] ?? 0, 0, ',', '.') }}</span>
                            
                            <input type="hidden" name="fares[{{ $vehicle->id }}]" value="{{ $fares[$vehicle->id] ?? 0 }}">
                        </div>
                    </label>
                    @endforeach
                @endif
            </div>

            <div class="button-container">
                <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('estimations.create') }}'">BACK</button>
                <button type="submit" class="btn-primary">NEXT</button>
            </div>
            
        </form>

    </div>

</body>
</html>
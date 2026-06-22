<html>
<head>
    <title>Ride Estimations</title>
    <style>
        body { padding: 25px; color: #333; }
        h1 { font-size: 24px; font-weight: bold; }
        hr { border: 0; border-top: 1px solid #ccc; margin-bottom: 20px; }
        .route-path { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .distance { color: #666; font-size: 14px; margin-bottom: 25px; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        .option-card { border: 1px solid #ccc; padding: 15px; margin-bottom: 12px; display: flex; gap: 15px; background-color: #f9f9f9; cursor: pointer;}
        .vehicle-name { font-weight: bold; }
    </style>
</head>
<body>

    <h1>Ride Estimations</h1>
    <hr>

    <div class="route-path">{{ $estimation->origin }} &rarr; {{ $estimation->destination }}</div>
    <div class="distance">Distance: {{ $estimation->distance }} Km</div>

    <div class="section-title">Available Vehicles</div>
    
    <form action="{{ route('estimations.selectVehicle') }}" method="POST">
        @csrf
        <input type="hidden" name="estimation_id" value="{{ $estimation->id }}">
        
        @if(isset($vehicleTypes) && $vehicleTypes->count() > 0)
            @foreach($vehicleTypes as $index => $vehicle)
            <label class="option-card">
                <input type="radio" name="vehicle_type_id" value="{{ $vehicle->id }}" {{ $index == 0 ? 'checked' : '' }} required>
                <div>
                    <div class="vehicle-name">{{ $vehicle->display_name }}</div>
                    <div>Fare: Rp {{ number_format($fares[$vehicle->id] ?? 0, 0, ',', '.') }}</div>
                </div>
            </label>
            @endforeach
        @endif

        <br>
        <button type="button" onclick="window.location.href='{{ route('bookings.create') }}'">BACK</button>
        <button type="submit">NEXT</button>
    </form>

</body>
</html>
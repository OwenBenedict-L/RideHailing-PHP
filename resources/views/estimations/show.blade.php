<html>
<head>
    <title>Ride Estimations</title>
    <style>
        body { font-family: sans-serif; padding: 25px; color: #333; }
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
        @php
            $hargaAwalMobil = $estimation->distance * 5000;
            $surgeMobil = rand(120, 130) / 100;
            $hargaMobil = $hargaAwalMobil * $surgeMobil;
        @endphp

        <label class="option-card">
            <input type="radio" name="vehicle_type" value="Bike" checked>
            <div>
                <div class="vehicle-name">Bike (Motorcycle)</div>
                <div>Fare: Rp {{ number_format($estimation->fare, 0, ',', '.') }}</div>
            </div>
        </label>

        <label class="option-card">
            <input type="radio" name="vehicle_type" value="Car">
            <div>
                <div class="vehicle-name">Car (Four-Wheeler)</div>
                <div>Fare: Rp {{ number_format($hargaMobil, 0, ',', '.') }}</div>
            </div>
        </label>

        <br>
        <button type="button" onclick="window.location.href='{{ route('bookings.create') }}'">BACK</button>
        <button type="submit">NEXT</button>
    </form>

</body>
</html>
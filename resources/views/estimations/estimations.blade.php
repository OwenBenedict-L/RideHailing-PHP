<html>
<head>
    <title>Select Your Ride</title>
    <style>
        body { font-family: sans-serif; padding: 25px; color: #333; background-color: #fff; }
        h1 { font-size: 24px; margin-bottom: 5px; font-weight: bold; }
        hr { border: 0; border-top: 1px solid #ccc; margin-bottom: 20px; }
        .route-info { margin-bottom: 25px; }
        .route-path { font-size: 18px; font-weight: 500; margin-bottom: 5px; }
        .distance { color: #666; font-size: 14px; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        .option-container { margin-bottom: 25px; max-width: 500px; }
        .option-card { border: 1px solid #ccc; padding: 15px; margin-bottom: 12px; border-radius: 4px; display: flex; align-items: center; gap: 15px; cursor: pointer; background-color: #fff; }
        .option-card:hover { background-color: #fcfcfc; }
        .option-card input[type="radio"] { transform: scale(1.2); cursor: pointer; }
        .vehicle-details { font-size: 15px; }
        .vehicle-name { font-weight: bold; margin-bottom: 3px; }
        .fare { color: #333; }
        .btn-group { display: flex; gap: 10px; margin-top: 30px; }
        button { padding: 6px 12px; font-size: 14px; border: 1px solid #ccc; background-color: #f8f9fa; cursor: pointer; border-radius: 3px; }
        button:hover { background-color: #e2e6ea; }
        button[type="submit"] { background-color: #fff; }
    </style>
</head>
<body>

    <h1>Select Your Ride</h1>
    <hr>

    <div class="route-info">
        <div class="route-path">{{ $estimation->origin }} &rarr; {{ $estimation->destination }}</div>
        
        <div class="distance">
            Distance: {{ $estimation->distance }} Km &bull; Est. Time: {{ $estimation->estimated_time }} mins
        </div>
    </div>

    <div class="section-title">Available Vehicles</div>

    <form action="{{ route('estimation.checkout', $estimation->id) }}" method="POST">
        @csrf
        
        @php
            // Menghitung harga mobil secara dinamis di tampilan
            $hargaMotor = $estimation->fare;
            $hargaMobil = ($estimation->distance * 6500) * $estimation->surge_multiplier;
        @endphp

        <div class="option-container">
            <label class="option-card">
                <input type="radio" name="vehicle_type" value="Bike" checked required>
                <div class="vehicle-details">
                    <div class="vehicle-name">RideApp Bike (Motorcycle)</div>
                    <div class="fare">Fare: Rp {{ number_format($hargaMotor, 0, ',', '.') }}</div>
                </div>
            </label>

            <label class="option-card">
                <input type="radio" name="vehicle_type" value="Car">
                <div class="vehicle-details">
                    <div class="vehicle-name">RideApp Car (Four-Wheeler)</div>
                    <div class="fare">Fare: Rp {{ number_format($hargaMobil, 0, ',', '.') }}</div>
                </div>
            </label>
        </div>

        <div class="btn-group">
            <button type="button" onclick="window.location.href='{{ route('bookings.create') }}'">CHANGE ROUTE</button>
            <button type="submit">NEXT</button>
        </div>
    </form>

</body>
</html>
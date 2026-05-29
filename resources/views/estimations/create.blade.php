<!DOCTYPE html>
<html>
<body>
    <h2>Estimasi Perjalanan</h2>
    <hr>

    <form action="{{ route('estimations.store') }}" method="POST">
        @csrf
        <label>Pickup Location:</label><br>
        <input type="text" name="pickup_location" placeholder="Enter pickup location" required>
        <br><br>
        
        <label>Destination Location:</label><br>
        <input type="text" name="destination_location" placeholder="Enter destination location" required>
        <br><br>

        <a href="{{ route('dashboard.user') }}">
            <button type="button">Kembali</button>
        </a>
        
        <button type="submit">Cek Harga</button>
    </form>
</body>
</html>
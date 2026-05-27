<h1>Form Pemesanan Perjalanan</h1>

<form method="POST" action="{{ route('bookings.store') }}">
    @csrf
    
    Pickup Location:
    <br>
    <input name="pickup_location" placeholder="Enter pickup location" required>
    <br><br>
    
    Destination Location:
    <br>
    <input name="destination_location" placeholder="Enter destination location" required>
    <br><br>
    
    Promo Code (Optional):
    <br>
    <input name="promo_code" placeholder="Example: UNTAR">
    <br><br>
    
    <a href="/dashboard"><button type="button">BACK</button></a>
    <button type="submit">NEXT</button>
</form>

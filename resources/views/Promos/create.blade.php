<html>
<body>
    <h1>Create New Promo</h1>

    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/promos') }}">
        @csrf
        
        Promo Code:
        <br>
        <input type="text" name="code" placeholder="Example: DISKON50" required>
        <br><br>

        Discount Percentage (1-100):
        <br>
        <input type="number" name="discount_percentage" placeholder="Example: 20" required>
        <br><br>

        Max Discount (Optional):
        <br>
        <input type="number" name="max_discount" placeholder="Example: 15000">
        <br><br>

        Expiry Date:
        <br>
        <input type="date" name="expiry_date" required>
        <br><br>

        <button type="submit">CREATE PROMO</button>
    </form>
    <br>
    <a href="{{ route('dashboard.user') }}">
        <button type="button">BACK TO DASHBOARD</button>
    </a>
</body>
</html>
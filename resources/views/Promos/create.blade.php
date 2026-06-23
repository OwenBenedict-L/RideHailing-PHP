<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Promo</title>
    @vite(['resources/css/create-promos.css'])
</head>
<body>

    <div class="promo-container">
        <a href="{{ route('dashboard.user') }}" class="btn-back">← BACK</a>

        <div class="promo-header">
            <h2>CREATE NEW PROMO</h2>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/promos') }}">
            @csrf
            
            <div class="form-group">
                <label for="code">Promo Code</label>
                <input type="text" id="code" name="code" placeholder="Example: DISKON50" required>
            </div>

            <div class="form-group">
                <label for="discount_percentage">Discount Percentage (1-100)</label>
                <input type="number" id="discount_percentage" name="discount_percentage" min="1" max="100" placeholder="Example: 20" required>
            </div>

            <div class="form-group">
                <label for="max_discount">Max Discount (Optional)</label>
                <input type="number" id="max_discount" name="max_discount" placeholder="Example: 15000">
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
            </div>

            <button type="submit" class="btn-submit">CREATE PROMO</button>
        </form>
    </div>

</body>
</html>
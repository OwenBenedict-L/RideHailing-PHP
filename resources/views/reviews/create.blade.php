<html>
<head>
    <title>Rate Driver</title>
</head>
<body style="padding: 20px;">

    <div style="max-width: 500px; background: white; padding: 20px; border-radius: 8px; border: 1px solid #000000;">
        <h2>Rate & Review Trip #{{ $booking->id }}</h2>
        <hr>

        <p style="font-size: 16px;">
            <strong>Driver:</strong> {{ $booking->driver->name ?? 'Driver' }}<br>
            <strong>Route:</strong> {{ $booking->pickup_location }} ➔ {{ $booking->destination_location }}
        </p>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('reviews.store', $booking->id) }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label><strong>Rating:</strong></label><br>
                <select name="rating" required style="width: 100%; padding: 8px; margin-top: 5px; font-size: 15px;">
                    <option value="">-- Select Stars --</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5/5 - Excellent)</option>
                    <option value="4">⭐⭐⭐⭐ (4/5 - Good)</option>
                    <option value="3">⭐⭐⭐ (3/5 - Okay)</option>
                    <option value="2">⭐⭐ (2/5 - Poor)</option>
                    <option value="1">⭐ (1/5 - Terrible)</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label><strong>Comment (Optional):</strong></label><br>
                <textarea name="comment" rows="4" placeholder="How was the ride?" style="width: 100%; padding: 8px; margin-top: 5px;"></textarea>
            </div>

            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; font-weight: bold; cursor: pointer; border-radius: 4px;">
                Submit Review
            </button>

            <a href="{{ route('bookings.index') }}" style="margin-left: 15px; text-decoration: none; color: #000000;">Cancel</a>
        </form>
    </div>

</body>
</html>
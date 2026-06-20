<html>
<head>
    <title>Edit Review</title>
</head>
<body style="padding: 20px; font-family: sans-serif; background-color: #f4f6f9;">

    <div style="max-width: 500px; background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        <h2>Edit Your Review for Trip #{{ $booking->id }}</h2>
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

        <form action="{{ route('reviews.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label><strong>Rating:</strong></label><br>
                <select name="rating" required style="width: 100%; padding: 8px; margin-top: 5px; font-size: 15px;">
                    <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5 - Excellent)</option>
                    <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5 - Good)</option>
                    <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3/5 - Okay)</option>
                    <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐ (2/5 - Poor)</option>
                    <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐ (1/5 - Terrible)</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label><strong>Comment (Optional):</strong></label><br>
                <textarea name="comment" rows="4" style="width: 100%; padding: 8px; margin-top: 5px;">{{ old('comment', $review->comment) }}</textarea>
            </div>

            <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; font-weight: bold; cursor: pointer; border-radius: 4px;">
                Update Review
            </button>

            <a href="{{ route('bookings.index') }}" style="margin-left: 15px; text-decoration: none; color: #666;">Cancel</a>
        </form>
    </div>

</body>
</html>
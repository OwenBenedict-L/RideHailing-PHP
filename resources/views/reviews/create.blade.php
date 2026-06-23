<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Driver - RideApp</title>
    @vite(['resources/css/review.css'])
</head>
<body>
    <div class="review-wrapper">
        <a href="{{ route('bookings.index') }}" class="btn-back">← BACK TO MY BOOKINGS</a>
        <div class="review-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Rate Your Experience</h2>
                    <p class="header-subtitle">Trip Booking #{{ $booking->id }}</p>
                </div>
                <div class="review-icon">⭐</div>
            </div>
            <div class="trip-summary-box">
                <div class="driver-info">
                    <span class="driver-avatar">👤</span>
                    <div>
                        <p class="driver-name">{{ $booking->driver->name ?? 'Driver' }}</p>
                        <span class="badge badge-success">Driver Partner</span>
                    </div>
                </div>
                <div class="route-info">
                    <div class="route-point">
                        <span class="dot-pickup"></span>
                        <span>Pickup: {{ $booking->pickup_location }}</span>
                    </div>
                    <div class="route-point" style="margin-top: 6px;">
                        <span class="dot-dest"></span>
                        <span>Destination: {{ $booking->destination_location }}</span>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('reviews.store', $booking->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rating">Give Star Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="" disabled selected>-- Select Stars --</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5/5 - Perfect Ride! 🔥)</option>
                        <option value="4">⭐⭐⭐⭐ (4/5 - Very Good 👍)</option>
                        <option value="3">⭐⭐⭐ (3/5 - Okay 😐)</option>
                        <option value="2">⭐⭐ (2/5 - Below Average 🙁)</option>
                        <option value="1">⭐ (1/5 - Terrible 😡)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Leave a Comment (Optional):</label>
                    <textarea name="comment" id="comment" rows="4" 
                              placeholder="How was your experience?" 
                              class="custom-textarea"></textarea>
                </div>
                <div class="button-group" style="margin-top: 16px;">
                    <button type="submit" class="btn btn-review-submit" style="flex: 2;">
                        SUBMIT REVIEW
                    </button>
                    <a href="{{ route('bookings.index') }}" class="btn btn-cancel" style="flex: 1;">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
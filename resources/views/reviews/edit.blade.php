<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review - RideApp</title>
    @vite(['resources/css/review.css'])
</head>
<body>
    <div class="review-wrapper">
        <a href="{{ route('bookings.index') }}" class="btn-back">← BACK TO MY BOOKINGS</a>
        <div class="review-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Edit Your Review</h2>
                    <p class="header-subtitle">Trip Booking #{{ $review->booking->id ?? '4' }}</p>
                </div>
                <div class="review-icon">✏️</div>
            </div>
            <div class="trip-summary-box">
                <div class="driver-info">
                    <span class="driver-avatar">👤</span>
                    <div>
                        <p class="driver-name">{{ $review->booking->driver->name ?? 'Driver' }}</p>
                        <span class="badge badge-success">Driver Partner</span>
                    </div>
                </div>
                <div class="route-info">
                    <div class="route-point">
                        <span class="dot-pickup"></span>
                        <span>Pickup: {{ $review->booking->pickup_location ?? 'Pickup Point' }}</span>
                    </div>
                    <div class="route-point" style="margin-top: 6px;">
                        <span class="dot-dest"></span>
                        <span>Destination: {{ $review->booking->destination_location ?? 'Destination Point' }}</span>
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
            <form action="{{ route('reviews.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="rating">Update Star Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="">-- Select Stars --</option>
                        <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5 - Perfect Ride! 🔥)</option>
                        <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5 - Very Good 👍)</option>
                        <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3/5 - Okay 😐)</option>
                        <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2/5 - Below Average 🙁)</option>
                        <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>⭐ (1/5 - Terrible 😡)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Update Comment (Optional):</label>
                    <textarea name="comment" id="comment" rows="4" 
                              placeholder="How was your experience?" 
                              class="custom-textarea">{{ old('comment', $review->comment) }}</textarea>
                </div>
                <div class="button-group" style="margin-top: 16px;">
                    <button type="submit" class="btn btn-review-update" style="flex: 2;">
                        UPDATE REVIEW
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
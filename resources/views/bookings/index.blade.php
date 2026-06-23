<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    @vite(['resources/css/booking-index.css'])
</head>
<body>

    <a href="{{ route('dashboard.user') }}" class="back-link">&larr; BACK</a>

    <h1>Booking History</h1>

    @if(session('success'))
        <div class="alert-box alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-box alert-error">
            {{ session('error') }}
        </div>
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="top-controls">
        <a href="{{ route('bookings.create') }}">
            <button type="button" class="btn-create">Create New Booking</button>
        </a>
        <button type="button" class="btn-refresh" onclick="window.location.reload();">↻ Refresh</button>
    </div>

    @if($bookings->isEmpty())
        <p style="text-align: center; color: #718096; margin-top: 20px;">You haven't booked any rides yet...</p>
    @else
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order Time</th>
                    <th>Trip Route</th>
                    <th>Fare</th>
                    <th>Distance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $booking->created_at->format('d M Y') }} <br>
                            <span style="color: #718096; font-size: 13px;">{{ $booking->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td>
                            <strong>From:</strong> {{ $booking->pickup_location }} <br>
                            <strong>To:</strong> {{ $booking->destination_location }}
                        </td>
                        <td><strong>Rp {{ number_format($booking->fare, 0, ',', '.') }}</strong></td>
                        <td>{{ $booking->distance }} Km</td>
                        <td>
                            @if($booking->status === 'confirmed')
                                <div style="margin-bottom: 6px;">
                                    <span style="color: green; font-weight: bold;">
                                        Accepted by: {{ $booking->driver->name }}
                                    </span> 
                                    <br>
                                    <small>Plate: {{ $booking->driver->license_plate }}</small>
                                </div>

                                <a href="{{ route('chat.show.user', $booking->driver->id) }}" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 5px;">
                                    🗪 Chat Driver
                                </a>

                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;" 
                                    onsubmit="return confirm('Are you sure you want to cancel this ride?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #dc3545 !important; color: white !important; height: auto !important; padding: 4px 8px !important; font-size: 12px !important;">
                                        Cancel
                                    </button>
                                </form>

                            @elseif($booking->status === 'on_way')
                                <div style="margin-bottom: 6px;">
                                    <span style="color: #9932cc; font-weight: bold;">
                                        ➔ ON THE WAY
                                    </span> 
                                    <br>
                                    <small style="color: gray;">Riding with {{ $booking->driver->name }}</small>
                                </div>

                                <a href="{{ route('chat.show.user', $booking->driver->id) }}" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 5px;">
                                    🗪 Chat Driver
                                </a>

                            @elseif($booking->status === 'completed')
                                <div style="margin-bottom: 6px;">
                                    <span style="color: #28a745; font-weight: bold;">
                                        ✔ TRIP COMPLETED
                                    </span>
                                </div>

                                @if(!$booking->review)
                                    <a href="{{ route('reviews.create', $booking->id) }}" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 5px;">
                                        ☆ Rate & Review
                                    </a>
                                @else
                                    <div style="font-size: 13px; color: #555; margin-top: 4px;">
                                        <strong>You rated:</strong> {{ str_repeat('⭐', $booking->review->rating) }}
                                        <br>
                                        <a href="{{ route('reviews.edit', $booking->id) }}" style="color: #007bff; text-decoration: none; font-size: 11px; font-weight: bold; display: inline-block; margin-top: 2px;">
                                            ✍️ Edit Review
                                        </a>
                                    </div>
                                @endif

                            @elseif($booking->status === 'cancelled')
                                <span style="color: red; font-weight: bold;">
                                    ✖ TRIP CANCELLED
                                </span>
                            
                            @else
                                <div style="margin-bottom: 6px;">
                                    <span style="color: orange; font-weight: bold;">
                                        {{ strtoupper($booking->status) }} (Searching for Driver...)
                                    </span>
                                </div>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;" 
                                    onsubmit="return confirm('Are you sure you want to cancel this ride?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #dc3545 !important; color: white !important; height: auto !important; padding: 4px 8px !important; font-size: 12px !important;">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
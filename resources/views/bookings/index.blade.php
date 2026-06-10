<html>
<body>
<h1>Booking History</h1>

@if(session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
    <br>
@endif

@if(session('error'))
    <div style="color: red; font-weight: bold;">
        {{ session('error') }}
    </div>
    <br>

    <script>
        alert("{{ session('error') }}");
    </script>
@endif

<a href="{{ route('bookings.create') }}"><button>Create New Booking</button></a>
<a href="{{ route('dashboard.user') }}" style="margin-left: 5px;"><button>BACK</button></a>
<button onclick="window.location.reload();" style="margin-left: 5px;">↻ Refresh</button>
<br><br>

@if($bookings->isEmpty())
    <p>You haven't booked any rides yet...</p>
@else
    <table border="1" cellpadding="10" cellspacing="0">
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
                        {{ $booking->created_at->format('H:i') }} WIB
                    </td>
                    <td>
                        <strong>From:</strong> {{ $booking->pickup_location }} <br>
                        <strong>To:</strong> {{ $booking->destination_location }}
                    </td>
                    <td>Rp {{ number_format($booking->fare, 0, ',', '.') }}</td>
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

                            <a href="{{ route('chat.show.user', $booking->driver->id) }}" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold; margin-right: 5px;">
                                🗪 Chat Driver
                            </a>

                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;" 
                                onsubmit="return confirm('Are you sure you want to cancel this ride?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
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

                        @elseif($booking->status === 'completed')
                            <div style="margin-bottom: 6px;">
                                <span style="color: #28a745; font-weight: bold;">
                                    ✔ TRIP COMPLETED
                                </span>
                            </div>

                            <a href="#" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold; margin-right: 5px;">
                                ☆ Rate & Review
                            </a>

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
                                <button type="submit" style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
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

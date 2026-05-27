<h1>Booking History</h1>

@if(session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
    <br>
@endif

<a href="{{ route('bookings.create') }}"><button>Create New Booking</button></a>
<a href="/dashboard"><button>Back to Dashboard</button></a>
<br><br>

@if($bookings->isEmpty())
    <p>You haven't booked any rides yet...</p>
@else
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
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
                        <strong>From:</strong> {{ $booking->pickup_location }} <br>
                        <strong>To:</strong> {{ $booking->destination_location }}
                    </td>
                    <td>Rp {{ number_format($booking->fare, 0, ',', '.') }}</td>
                    <td>{{ $booking->distance }} Km</td>
                    <td>
                        @if($booking->driver_id)
                            <span style="color: green; font-weight: bold;">
                                Accepted by: {{ $booking->driver->name }}
                            </span> 
                            <br>
                            <small>Plate: {{ $booking->driver->license_plate }}</small>
                        @else
                            <span style="color: orange; font-weight: bold;">
                                {{ strtoupper($booking->status) }} (Searching for Driver...)
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

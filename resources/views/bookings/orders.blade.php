<html>
<body>
<h1>Available & History Orders</h1>

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

<a href="{{ route('dashboard.driver') }}">
    <button>BACK</button>
</a>
<button onclick="window.location.reload();" style="margin-left: 5px;">
    ↻ Refresh
</button>
<br><br>

@if($orders->isEmpty())
    <p>No active or historical orders at the moment. Please wait...</p>
@else
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Order Time</th>
                <th>Passenger</th>
                <th>Trip Route</th>
                <th>Fare</th>
                <th>Distance</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $order->created_at->format('d M Y') }} <br>
                        {{ $order->created_at->format('H:i') }} WIB
                    </td>
                    <td>{{ $order->user->name }}</td>
                    <td>
                        <strong>From:</strong> {{ $order->pickup_location }} <br>
                        <strong>To:</strong> {{ $order->destination_location }}
                    </td>
                    <td>Rp {{ number_format($order->fare, 0, ',', '.') }}</td>
                    <td>{{ $order->distance }} Km</td>
                    <td>
                        @if($order->status === 'pending')
                            <div style="margin-bottom: 6px;">
                                <span style="color: orange; font-weight: bold;">
                                    SEARCHING CUSTOMER
                                </span>
                            </div>
                            
                            <form method="POST" action="{{ route('bookings.orders.accept', $order->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background-color: #28a745; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer; margin-right: 5px;">
                                    ACCEPT
                                </button>
                            </form>

                            <form method="POST" action="{{ route('bookings.orders.reject', $order->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                    REJECT
                                </button>
                            </form>

                        @elseif($order->status === 'confirmed')
                            <div style="margin-bottom: 6px;">
                                <span style="color: green; font-weight: bold;">
                                    ✔ ACCEPTED BY YOU
                                </span>
                            </div>
                            <a href="{{ route('chat.show.driver', ['userId' => $order->user_id]) }}" style="display: inline-block; background-color: #17a2b8; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold;">
                                🗪 Chat User
                            </a>

                        @elseif($order->status === 'on_way')
                            <div style="margin-bottom: 6px;">
                                <span style="color: #9932cc; font-weight: bold;">
                                    ➔ ON THE WAY
                                </span>
                            </div>
                            <a href="{{ route('chat.show.driver', ['userId' => $order->user_id]) }}" style="display: inline-block; background-color: #17a2b8; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold;">
                                🗪 Chat User
                            </a>

                        @elseif($order->status === 'completed')
                            <div style="margin-bottom: 6px;">
                                <span style="color: #28a745; font-weight: bold;">
                                    ✔ TRIP COMPLETED
                                </span>
                            </div>

                        @elseif($order->status === 'cancelled')
                            <span style="color: red; font-weight: bold;">
                                ✖ TRIP CANCELLED
                            </span>
                            
                        @else
                            <span style="color: gray; font-weight: bold;">
                                {{ strtoupper($order->status) }}
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($order->status === 'confirmed')
                        <form method="POST" action="{{ route('bookings.orders.update', $order->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you have picked up the passenger?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="on_way">
                            <button type="submit" style="background-color: #007bff; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                🚀 Start Trip
                            </button>
                        </form>

                        @elseif($order->status === 'on_way')
                        <form method="POST" action="{{ route('bookings.orders.update', $order->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you have dropped off the passenger?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" style="background-color: #28a745; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                🏁 Complete Trip
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
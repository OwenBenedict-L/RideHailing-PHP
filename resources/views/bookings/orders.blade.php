<html>
<head>
    <title>Available Orders</title>
</head>
<body>
    <h2>Available Orders</h2>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div>
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('dashboard.driver') }}">[BACK TO DASHBOARD]</a>
    <br><br>

    @if($orders->isEmpty())
        <p>No active orders at the moment. Please wait...</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Passenger Name</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Fare</th>
                    <th>Distance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->pickup_location }}</td>
                        <td>{{ $order->destination_location }}</td>
                        <td>Rp {{ number_format($order->fare, 0, ',', '.') }}</td>
                        <td>{{ $order->distance }} km</td>
                        <td>
                            <form method="POST" action="{{ route('bookings.orders.accept', $order->id) }}">
                                @csrf
                                <button type="submit">
                                    ACCEPT ORDER
                                </button>
                            </form>

                            <form method="POST" action="{{ route('bookings.orders.reject', $order->id) }}">
                                @csrf
                                <button type="submit">
                                    REJECT
                                </button>
                            </form>

                            <a href="{{ route('chat.show.driver', ['userId' => $order->user->id]) }}" style="display: inline-block; background-color: #28a745; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold; margin-right: 5px;">
                                🗪 Chat User
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
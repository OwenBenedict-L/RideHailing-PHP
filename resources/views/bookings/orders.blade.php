<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available & History Orders</title>
    @vite(['resources/css/orders.css'])
</head>
<body>
    <div class="page-container">
    <h1>Available & History Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    <div class="header-actions">
        <a href="{{ route('dashboard.driver') }}" class="btn-header">⬅ BACK</a>
        <button onclick="window.location.reload();" class="btn-header">↻ Refresh</button>
    </div>

    @if($orders->isEmpty())
        <div class="no-data">
            <p>No active or historical orders at the moment. Please wait...</p>
        </div>
    @else
        <div class="table-container">
            <table>
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
                                <span style="color: #666; font-size: 0.9em;">{{ $order->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td><strong>{{ $order->user->name }}</strong></td>
                            <td>
                                <div style="margin-bottom: 4px;"><strong>From:</strong> {{ $order->pickup_location }}</div>
                                <div><strong>To:</strong> {{ $order->destination_location }}</div>
                            </td>
                            <td style="font-weight: bold; color: #2c3e50;">Rp {{ number_format($order->fare, 0, ',', '.') }}</td>
                            <td>{{ $order->distance }} Km</td>
                            
                            <td>
                                <div class="col-stack">
                                    @if($order->status === 'pending')
                                        <span class="status-badge status-searching">SEARCHING CUSTOMER</span>
                                        <div style="display: flex; gap: 6px;">
                                            <form method="POST" action="{{ route('bookings.orders.accept', $order->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-accept">ACCEPT</button>
                                            </form>
                                            <form method="POST" action="{{ route('bookings.orders.reject', $order->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-reject">REJECT</button>
                                            </form>
                                        </div>

                                    @elseif($order->status === 'confirmed')
                                        <span class="status-badge status-accepted">✔ ACCEPTED BY YOU</span>
                                        <a href="{{ route('chat.show.driver', ['userId' => $order->user_id]) }}" class="btn btn-chat">
                                            🗪 Chat User
                                        </a>

                                    @elseif($order->status === 'on_way')
                                        <span class="status-badge status-onway">➔ ON THE WAY</span>
                                        <a href="{{ route('chat.show.driver', ['userId' => $order->user_id]) }}" class="btn btn-chat">
                                            🗪 Chat User
                                        </a>

                                    @elseif($order->status === 'completed')
                                        <span class="status-badge status-completed">✔ TRIP COMPLETED</span>

                                        @if($order->review)
                                            <div class="review-box">
                                                <div class="review-stars">
                                                    {{ str_repeat('⭐', $order->review->rating) }}
                                                </div>
                                                @if($order->review->comment)
                                                    <q class="review-comment">{{ $order->review->comment }}</q>
                                                @else
                                                    <span class="review-empty">(No written review)</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="review-empty">Waiting for passenger review...</span>
                                        @endif

                                    @elseif($order->status === 'cancelled')
                                        <span class="status-badge status-cancelled">✖ TRIP CANCELLED</span>
                                        
                                    @else
                                        <span class="status-badge status-default">{{ strtoupper($order->status) }}</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="col-stack" style="align-items: center;">
                                    @if($order->status === 'confirmed')
                                        <form method="POST" action="{{ route('bookings.orders.update', $order->id) }}" onsubmit="return confirm('Are you sure you have picked up the passenger?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="on_way">
                                            <button type="submit" class="btn-action btn-start-trip">
                                                🚀 Start Trip
                                            </button>
                                        </form>

                                    @elseif($order->status === 'on_way')
                                        <form method="POST" action="{{ route('bookings.orders.update', $order->id) }}" onsubmit="return confirm('Are you sure you have dropped off the passenger?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-action btn-complete-trip">
                                                🏁 Complete
                                            </button>
                                        </form>
                                    @else
                                        <span style="color: #bbb; font-size: 0.85rem; font-style: italic;">No Action</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

</body>
</html>
<html>
<body>
<h1>Driver Notification History</h1>

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
@endif

<a href="{{ route('dashboard.driver') }}"><button>BACK</button></a>
<button onclick="window.location.reload();" style="margin-left: 5px;">↻ Refresh</button>

@if(!$notifications->isEmpty())
    <form action="{{ route('driver-notifications.markAllRead') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="margin-left: 5px;">✓ Mark All as Read</button>
    </form>

    <form action="{{ route('driver-notifications.deleteAll') }}" method="POST" style="display: inline;" 
          onsubmit="return confirm('Are you sure you want to delete ALL notifications?')">
        @csrf
        @method('DELETE')
        <button type="submit" style="margin-left: 5px;">🗑 Delete All</button>
    </form>
@endif

<br><br>

@if($notifications->isEmpty())
    <p>You don't have any notifications yet...</p>
@else
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Received Time</th>
                <th>Category</th>
                <th>Notification Details</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr style="{{ $notification->is_read ? 'background-color: #ffffff;' : 'background-color: #f4f7fc;' }}">
                    <td>
                        {{ $loop->iteration }}
                        @if(!$notification->is_read)
                            <span style="color: red; font-weight: bold; font-size: 11px; display: block;">● NEW</span>
                        @endif
                    </td>
                    <td>
                        {{ $notification->created_at->format('d M Y') }} <br>
                        {{ $notification->created_at->format('H:i') }} WIB <br>
                        <small style="color: gray;">{{ $notification->created_at->diffForHumans() }}</small>
                    </td>
                    <td style="text-align: center;">
                        @if($notification->type === 'ride')
                            <span style="background-color: #007bff; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; font-family: sans-serif;">RIDE</span>
                        @elseif($notification->type === 'wallet')
                            <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; font-family: sans-serif;">WALLET</span>
                        @elseif($notification->type === 'chat')
                            <span style="background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; font-family: sans-serif;">CHAT</span>
                        @elseif($notification->type === 'security')
                            <span style="background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; font-family: sans-serif;">SECURITY</span>
                        @else
                            <span style="background-color: #6c757d; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; font-family: sans-serif;">SYSTEM</span>
                        @endif
                    </td>
                    <td>
                        <strong style="font-size: 15px; {{ $notification->is_read ? 'color: #333;' : 'color: #002752;' }}">
                            {{ $notification->title }}
                        </strong>
                        <br>
                        <span style="color: #555; font-size: 13px;">{{ $notification->message }}</span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; align-items: center;">
                            @if(!$notification->is_read)
                                <form action="{{ route('driver-notifications.update', $notification->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_read" value="1">
                                    <button type="submit" style="background-color: #6c757d; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                        Mark as Read
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('driver-notifications.show', $notification->id) }}" style="display: inline-block; background-color: #007bff; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; font-family: sans-serif; font-weight: bold;">
                                View
                            </a>

                            <form action="{{ route('driver-notifications.destroy', $notification->id) }}" method="POST" style="margin: 0;"
                                onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Notification Detail</title>
    @vite(['resources/css/drivernotification-show.css']) 
</head>
<body>

    <h1>Driver Notification Detail</h1>

    <div class="detail-card">
        <h3>Notification Info</h3>
        <p><strong>Received Time:</strong> {{ $driverNotification->created_at->format('d M Y, H:i') }} WIB</p>
        <p><strong>Category:</strong> {{ strtoupper($driverNotification->type) }}</p>

        <hr>

        <h3>Message Details</h3>
        <p><strong>Title:</strong> {{ $driverNotification->title }}</p>
        <p><strong>Message:</strong> <span>{{ $driverNotification->message }}</span></p>

        <hr>

        <h3>Status</h3>
        @if($driverNotification->is_read)
            <p style="color: green; font-weight: bold;">This notification has been read.</p>
        @else
            <p style="color: red; font-weight: bold;">This notification is unread.</p>
        @endif
    </div>

    <div class="action-container">
        <a href="{{ route('driver-notifications.index') }}">
            <button type="button">⬅ BACK TO INBOX</button>
        </a>
    </div>

</body>
</html>
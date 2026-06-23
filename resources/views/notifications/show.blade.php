<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Detail - Ride App</title>
    @vite(['resources/css/notification-show.css'])
</head>
<body>

    <h1>Notification Detail</h1>

    <div class="detail-card">
        
        <h3 class="section-title">NOTIFICATION INFO</h3>
        <p><strong>Received Time:</strong> {{ $userNotification->created_at->format('d M Y, H:i') }} WIB</p>
        <p><strong>Category:</strong> {{ strtoupper($userNotification->type) }}</p>

        <hr>

        <h3 class="section-title">MESSAGE DETAILS</h3>
        <p><strong>Title:</strong> {{ $userNotification->title }}</p>
        <p><strong>Message:</strong> {{ $userNotification->message }}</p>

        <hr>

        <h3 class="section-title">STATUS</h3>
        @if($userNotification->is_read)
            <div class="status-alert success">
                This notification has been read.
            </div>
        @else
            <div class="status-alert danger">
                This notification is unread.
            </div>
        @endif
        
    </div>

    <div class="action-container">
        <a href="{{ route('notifications.index') }}" class="btn-back">
            BACK
        </a>
    </div>

</body>
</html>
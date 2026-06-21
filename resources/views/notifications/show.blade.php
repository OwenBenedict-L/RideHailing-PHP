<html>
<body>
<h1>Notification Detail</h1>

<h3>Notification Info</h3>
<p><strong>Received Time:</strong> {{ $userNotification->created_at->format('d M Y, H:i') }} WIB</p>
<p><strong>Category:</strong> {{ strtoupper($userNotification->type) }}</p>

<hr>

<h3>Message Details</h3>
<p>Title: <strong>{{ $userNotification->title }}</strong></p>
<p>Message: <span>{{ $userNotification->message }}</span></p>

<hr>

<h3>Status</h3>
@if($userNotification->is_read)
    <p style="color: green; font-weight: bold;">This notification has been read.</p>
@else
    <p style="color: red; font-weight: bold;">This notification is unread.</p>
@endif

<br>
<a href="{{ route('notifications.index') }}">
    <button type="button" style="padding: 10px;">BACK TO INBOX</button>
</a>

</body>
</html>
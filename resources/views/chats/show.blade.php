<html>
<body>

<table>
    <tr>
        @if(auth('user')->check())
        <th style="border: none">
            <h2>
                <a href="{{ route('bookings.index') }}">
                    <button type="button">Back</button>
                </a>
            </h2>
        </th>
        @endif

        @if(auth('driver')->check())
        <th style="border: none">
            <h2>
                <a href="{{ route('driver.orders') }}">
                    <button type="button">Back</button>
                </a>
            </h2>
        </th>
        @endif

        <th style="border: none">
            <h2>{{ $contact->name }}</h2>
        </th>
    </tr>
</table>

<hr>

@if($chat->isEmpty())
    <p>No messages yet.</p>
@else
    @foreach($chat as $message)
        @if(auth('user')->check() && $message->senderUser_id == auth('user')->id())
            <p><strong>Me :</strong> {{ $message->message }}</p>
        @elseif(auth('driver')->check() && $message->senderDriver_id == auth('driver')->id())
            <p><strong>Me :</strong> {{ $message->message }}</p>
        @else
            <p><strong>{{ $contact->name }} :</strong> {{ $message->message }}</p>
        @endif
    @endforeach
@endif

<hr>

@if(auth('user')->check())
    <form action="{{ route('chat.send.user', $contact->id) }}" method="POST">
        @csrf
        <input type="text" name="message" placeholder="Typing..." required>
        <button type="submit">Send</button>
    </form>
@endif

@if(auth('driver')->check())
    <form action="{{ route('chat.send.driver', $contact->id) }}" method="POST">
        @csrf
        <input type="text" name="message" placeholder="Typing..." required>
        <button type="submit">Send</button>
    </form>
@endif

</body>
</html>
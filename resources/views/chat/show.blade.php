<html>
<body>
    <table>
        <tr>
            @if(auth('user')->check())
            <th style="border: none">
                <h2>
                    <a href="/bookings">
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

    @foreach($chat as $chat)
        @if(auth('user')->check() && $chat->senderUser_id == auth('user')->id())
        <p>Me : {{ $chat->message }}</p>

        @elseif(auth('driver')->check() && $chat->senderDriver_id == auth('driver')->id())
        <p>Me : {{ $chat->message }}</p>

        @else
            <p>
                {{ $contact->name }} :
                {{ $chat->message }}
            </p>

        @endif
    @endforeach

    <hr>

    @if(auth('user')->check())
        <form action="{{ route('chat.send.user', ['driverId' => $contact->id]) }}" method="POST">
            @csrf
            
            <input type="hidden" name="receiverDriver_id" value="{{ $contact->id }}">
            <input type="text" name="message" placeholder="Typing...." required>

            <button type="submit"> Send </button>
        </form>
    @endif

    @if(auth('driver')->check())
        <form action="{{ route('chat.send.driver') }}" method="POST">
            @csrf

            <input type="hidden" name="receiverUser_id" value="{{ $contact->id }}">
            <input type="text" name="message" placeholder="Typing...." required>

            <button type="submit"> Send </button>
        </form>
    @endif
</body>
</html>

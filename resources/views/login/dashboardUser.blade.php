<html>
<body>
    <h2>Hello User: {{ Auth::user()->name }}</h2>
    <ul>
        <li>
            <a href="{{ route('notifications.index')}} ">
                <button type= button>Notification</button>
            </a>
        </li>

        <br>

        <li>CS</li>

        <br>

        <li>
            <a href="{{ route('wallet.balance') }} ">
                <button type= button>Wallet</button>
            </a>
        </li>

        <br>

        <li>            
            <a href="{{ route('bookings.index') }}">
                <button type="button">Bookings</button>
            </a>
        </li>

        <br>

        <li>
            <a href="{{ route('helpcenter.index') }}">
                <button type="button">Help Center</button>
            </a>
        </li>

        @if(Auth::user()->email === 'developer@gmail.com')

        <li>
            <a href="{{ url('/promos/create') }}">
                <button type="button">Create Promo</button>
            </a>
        </li>

        <br>

        <li>
            <a href="{{ url('/promos') }}">
                <button type="button">Promo List</button>
            </a>
        </li>
        @endif
    </ul>

    <br>

    <form method="POST" action="/logout-user">
        @csrf
        <button type="submit">LOGOUT</button>
    </form>
</body>
</html>
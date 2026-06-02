<html>
<body>
    <h2>Hello User: {{ Auth::user()->name }}</h2>
    <ul>
        <li>[Notification]</li>
        <li>[CS]</li>
        <li>
            <a href="{{ route('wallet.balance') }} ">
                <button type= button>[wallet]</button>
            </a>
        </li>
        <li>            
            <a href="{{ route('bookings.index') }}">
                <button type="button">[bookings]</button>
            </a>
        </li>
        <li>
            <a href="{{ route('helpcenter.index') }}">
                <button type="button">[help center]</button>
            </a>
        </li>
        @if(Auth::user()->email === 'developer@gmail.com')
        <li>
            <a href="{{ url('/promos/create') }}">
                <button type="button">[create promo]</button>
            </a>
        </li>
        <li>
            <a href="{{ url('/promos') }}">
                <button type="button">[promo list]</button>
            </a>
        </li>
        @endif
    </ul>

    <br><form method="POST" action="/logout-user">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
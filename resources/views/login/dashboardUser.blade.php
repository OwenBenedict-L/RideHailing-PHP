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
            <a href="{{ route('estimations.create') }}">
                <button type="button">[ride estimations]</button>
            </a>
        </li>
    </ul>
    
    <br><form method="POST" action="/logout">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
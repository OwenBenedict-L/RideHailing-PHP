<html>
<body>
    <h2>Hello Driver: {{ Auth::guard('driver')->user()->name }}</h2>

    <ul>
        <li>[Notification]</li>
        <li>
            <a href="{{ route('helpcenter.store') }}">
                <button type="button">Help Center</button>
            </a>
        </li>
        <li>
            <a href="{{ route('driver.wallet.balance') }}">
                <button type="button">Wallet</button>
            </a>
        </li>
        <li>
            <a href="{{ route('driver.orders') }}">
                <button type="button">Look For Orders</button>
            </a>
        </li>
    </ul>

    <form method="POST" action="/logout-driver">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
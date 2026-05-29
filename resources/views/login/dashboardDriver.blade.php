<html>
<body>
    <h2>Hello Driver: {{ Auth::guard('driver')->user()->name }}</h2>

    <ul>
        <li>[Notification]</li>
        <li>[CS]</li>
        <li><a href="{{ route('driver.orders') }}">Look For Orders [Active Order]</a></li>
    </ul>

    <form method="POST" action="/logout-driver">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
<html>
<body>
    <h2>Hello Driver: {{ Auth::user()->name }}</h2>
    <ul>
        <li>[Notification]</li>
        <li>[CS]</li>
        <li>[Active Order]</li>
    </ul>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
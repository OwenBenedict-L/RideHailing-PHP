<html>
<body>
    <h2>Hello User: {{ Auth::user()->name }}</h2>
    <ul>
        <li>[notification]</li>
        <li>[CS]</li>
        <li>[wallet]</li>
        <li>[booking]</li>
    </ul>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
<html>
<body>
    <h2>Hello CS: {{ Auth::guard('cs')->user()->name }}</h2>

    <ul>
        <li>
            <a href="{{ route('cs.users') }}">
                <button type="button">[User]</button>
            </a>
        </li>
    </ul>

    <form method="POST" action="/logout-cs">
        @csrf
        <button type="submit">[LOGOUT]</button>
    </form>
</body>
</html>
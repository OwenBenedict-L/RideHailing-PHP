<html>
<body>
    <h2>Wallet Information</h2>
        <p>Balance: {{ number_format($balance, 0, ',', '.') }}</p>
        <a href="{{ route('dashboard') }}">
            <button>BACK</button>
        </a>
</body>
</html>
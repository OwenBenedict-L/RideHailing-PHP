<html>
<body>
    <h2>Wallet Information</h2>
    <div style="display: flex; gap: 20px;">
        <p>Balance: {{ number_format($balance, 0, ',', '.') }}</p>
    </div>
    <a href="{{ route('dashboard.driver') }}">
            <button>BACK</button>
    </a>
</body>
</html>
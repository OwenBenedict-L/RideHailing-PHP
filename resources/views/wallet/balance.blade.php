<html>
<body>
    <h2>Wallet Information</h2>
    @if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
    @endif
    <div style="display: flex; gap: 20px;">
        <p>Balance: Rp{{ number_format($balance, 0, ',', '.') }}</p>
        <p>
            <a href="{{ route('wallet.topup') }}">
                <button>TOP UP</button>
            </a>
        </p>
    </div>
    <div>
        <p>
            <a href="{{ route('wallet.history') }}">
                <button>HISTORY</button>
            </a>
        </p>
    </div>
    <a href="{{ route('dashboard.user') }}">
            <button>BACK</button>
    </a>
</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Wallet - RideApp</title>
    @vite(['resources/css/wallet.css'])
</head>
<body>
    <div class="wallet-wrapper">
        <a href="{{ route('dashboard.driver') }}" class="btn-back">← BACK</a>
        <div class="wallet-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Driver Wallet</h2>
                    <p class="header-subtitle">Manage your daily trip earnings</p>
                </div>
                <div class="wallet-icon">💵</div>
            </div>
            @if(session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="balance-box">
                <p class="balance-label">Total Earnings</p>
                <h1 class="balance-amount">Rp{{ number_format($balance ?? 0, 0, ',', '.') }}</h1>
            </div>
            <div class="button-group">
                <a href="{{ route('driver.wallet.withdraw') }}" class="btn btn-withdraw">
                    🏧 Withdraw
                </a>
                <a href="{{ route('driver.wallet.history') }}" class="btn btn-history">
                    📜 History
                </a>
            </div>
        </div>
    </div>
</body>
</html>
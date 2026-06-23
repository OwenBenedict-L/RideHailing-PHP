<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallet - RideApp</title>
    @vite(['resources/css/wallet.css'])
</head>
<body>
    <div class="wallet-wrapper">
        <a href="/dashboard-user" class="btn-back">← BACK</a>
        <div class="wallet-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Wallet Info</h2>
                    <p class="header-subtitle">RideApp Pay Balance</p>
                </div>
                <div class="wallet-icon">💳</div>
            </div>
            @if(session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="balance-box">
                <p class="balance-label">Available Balance</p>
                
                <h1 class="balance-amount">Rp{{ number_format($balance ?? 0, 0, ',', '.') }}</h1>
            </div>
            <div class="button-group">
                <a href="/wallet/topup" class="btn btn-topup">
                    ➕ Top Up
                </a>
                <a href="/wallet/history" class="btn btn-history">
                    📜 History
                </a>
            </div>
        </div>
    </div>
</body>
</html>
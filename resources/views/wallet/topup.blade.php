<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Wallet - RideApp</title>
    @vite(['resources/css/wallet.css'])
</head>
<body>
    <div class="wallet-wrapper">
        <a href="{{ route('wallet.balance') }}" class="btn-back">← BACK TO WALLET</a>
        <div class="wallet-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Top Up Wallet</h2>
                    <p class="header-subtitle">Add balance to your wallet</p>
                </div>
                <div class="wallet-icon">⚡</div>
            </div>
            @if ($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('wallet.topup.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Enter Amount:</label>
                    <div class="input-currency-wrapper">
                        <span class="currency-prefix">Rp</span>
                        <input type="number" name="amount" id="amount" min="1000" placeholder="1000" required>
                    </div>
                    <small class="help-text">Minimum top up is Rp1.000</small>
                </div>
                <button type="submit" class="btn-submit-topup">CONFIRM & TOP UP</button>
            </form>
        </div>
    </div>
</body>
</html>
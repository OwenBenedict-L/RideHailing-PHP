<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw to Bank - RideApp</title>
    @vite(['resources/css/wallet.css'])
</head>
<body>
    <div class="wallet-wrapper">
        <a href="{{ route('driver.wallet.balance') }}" class="btn-back">← BACK TO DRIVER WALLET</a>
        <div class="wallet-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Withdraw Funds</h2>
                    <p class="header-subtitle">Transfer cash directly to your bank</p>
                </div>
                <div class="wallet-icon">🏦</div>
            </div>
            <div class="balance-box" style="padding: 16px 20px; margin-bottom: 24px;">
                <p class="balance-label" style="font-size: 11px;">Withdrawable Balance</p>
                <h2 class="balance-amount" style="font-size: 24px;">Rp{{ number_format($wallet->balance, 0, ',', '.') }}</h2>
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
            <form action="{{ route('driver.wallet.withdraw.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="bank_name">Destination Bank:</label>
                    <input type="text" name="bank_name" id="bank_name" required 
                           value="{{ old('bank_name', $wallet->bank_name) }}" 
                           placeholder="e.g. BCA, Mandiri, BRI">
                </div>
                <div class="form-group">
                    <label for="bank_account_number">Account Number:</label>
                    <input type="text" name="bank_account_number" id="bank_account_number" required 
                           value="{{ old('bank_account_number', $wallet->bank_account_number) }}" 
                           placeholder="e.g. 12345678">
                </div>
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <label for="amount" style="margin: 0;">Withdrawal Amount:</label>
                    </div>
                    <div class="input-currency-wrapper">
                        <span class="currency-prefix">Rp</span>
                        <input type="number" name="amount" id="amount" required 
                               min="10000" max="{{ $wallet->balance }}" 
                               placeholder="10000">
                    </div>
                    <small class="help-text">Minimum withdrawal is Rp10.000</small>
                </div>
                <button type="submit" class="btn-submit-topup" style="background-color: #38A169;">
                    🏧 PROCESS WITHDRAWAL
                </button>
            </form>
        </div>
    </div>
</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - RideApp</title>
    @vite(['resources/css/wallet.css'])
</head>
<body>
    <div class="wallet-wrapper" style="max-width: 650px;">
        <a href="{{ route('wallet.balance') }}" class="btn-back">← BACK TO WALLET</a>
        <div class="wallet-card">
            <div class="card-header">
                <div>
                    <h2 class="header-title">Transaction History</h2>
                    <p class="header-subtitle">Track your RidePay cash flow</p>
                </div>
                <div class="wallet-icon">📜</div>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th class="align-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td class="col-date">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($trx->type) == 'topup' ? 'success' : 'danger' }}">
                                        {{ strtoupper($trx->type) }}
                                    </span>
                                </td>
                                <td class="col-desc">{{ $trx->description }}</td>
                                <td class="col-amount amount-{{ strtolower($trx->type) == 'topup' ? 'plus' : 'minus' }}">
                                    {{ strtolower($trx->type) == 'topup' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <div class="empty-content">
                                        <span class="empty-icon">💸</span>
                                        <p>No transaction history found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
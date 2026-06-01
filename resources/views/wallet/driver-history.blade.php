<html>
<body>
    <h1>Earnings & Withdrawal History</h1>
    <hr>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 700px; text-align: center;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <span style="color: {{ $trx->type == 'withdraw' ? 'red' : 'green' }}; font-weight: bold;">
                            {{ strtoupper($trx->type) }}
                        </span>
                    </td>
                    <td>{{ $trx->description }}</td>
                    <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No transaction history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>
    <a href="{{ route('driver.wallet.balance') }}">
        <button>BACK</button>
    </a>
</body>
</html>
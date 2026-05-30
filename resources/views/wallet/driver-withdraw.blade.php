<html>
<body>
    <h1>Withdraw to Bank Account</h2>
    <hr>
    <h2>Balance: Rp{{ number_format($wallet->balance, 0, ',', '.') }}</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('driver.wallet.withdraw.process') }}" method="POST">
        @csrf
        <div>
            <p>Bank Name (example: BCA, Mandiri)</p>
            <input type="text" name="bank_name" id="bank_name" required value="{{ old('bank_name', $wallet->bank_name) }}">
        </div>
        <br>
        <div>
            <p>Bank Account Number</p>
            <input type="text" name="bank_account_number" id="bank_account_number" required value="{{ old('bank_account_number', $wallet->bank_account_number) }}">
        </div>
        <br>
        <div>
            <p>Withdrawal Amount<p>
            <input type="number" name="amount" id="amount" required min="10000" placeholder="Min. 10000">
        </div>
        <br>
        <button type="submit">Process Withdrawal</button>
    </form>
    <br>
    <a href="{{ route('driver.wallet.balance') }}">
        <button>BACK</button>
    </a>
</body>
</html>
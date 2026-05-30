<html>
<body>
    <h2>TOP UP WALLET</h2>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('wallet.topup.process') }}" method="POST">
        @csrf
        <div>
            <p>Top Up Amount</p>
            <input type="number" name="amount" id="amount" min="1000" required>
        </div>
        <button type="submit">Confirm</button>
    </form>
    <a href="{{ route('wallet.balance') }}">
        <button>BACK</button>
    </a>
</body>
</html>
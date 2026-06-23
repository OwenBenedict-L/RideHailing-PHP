<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    @vite(['resources/css/dashboard.css'])
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">RideApp - Driver Portal
            <a href="{{ route('driver-notifications.index') }}" class="bell-link">🔔
                @if(\DB::table('driver_notifications')->where('driver_id', Auth::guard('driver')->id())->where('is_read', false)->count() > 0)
                    <span class="bell-badge">
                    {{ \DB::table('driver_notifications')->where('driver_id', Auth::guard('driver')->id())->where('is_read', false)->count() }}
                    </span>
                @endif
            </a>
        </div>
        <div class="navbar-user-zone">

            <span class="user-greeting">Hi, {{ Auth::guard('driver')->user()->name }} 🚗</span>
            
            <form method="POST" action="/logout-driver" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">LOGOUT</button>
            </form>
        </div>
    </header>

    <main class="dashboard-container">
        
        <div class="welcome-banner">
            <h2>Driver Dashboard</h2>
            <p>Welcome back! Ready to be rich?</p>
        </div>

        <section class="menu-grid">
            
            <a href="{{ route('driver.orders') }}" class="menu-box">
                <span class="menu-title">Look For Orders</span>
            </a>

            <a href="{{ route('driver.wallet.balance') }}" class="menu-box">
                <span class="menu-title">Wallet Balance</span>
            </a>

            <a href="{{ route('driver.helpcenter.index') }}" class="menu-box">
                <span class="menu-title">Help Center</span>
            </a>

        </section>

    </main>

</body>
</html>
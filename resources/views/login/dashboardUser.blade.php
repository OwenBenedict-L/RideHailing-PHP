<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    @vite(['resources/css/dashboard.css'])
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">RideApp
            <a href="{{ route('notifications.index') }}" class="bell-link">
                🔔
                @if(\DB::table('user_notifications')->where('user_id', Auth::id())->where('is_read', false)->count() > 0)
                    <span class="bell-badge">
                    {{ \DB::table('user_notifications')->where('user_id', Auth::id())->where('is_read', false)->count() }}
                    </span>
                @endif
            </a>
        </div>
        <div class="navbar-user-zone">
            
            <span class="user-greeting">Hi, {{ Auth::user()->name }} 👋</span>
            
            <form method="POST" action="/logout-user" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">LOGOUT</button>
            </form>
        </div>
    </header>

    <main class="dashboard-container">
        
        <div class="welcome-banner">
            <h2>Dashboard</h2>
            <p>Welcome back! Ready to go?</p>
        </div>

        <section class="menu-grid">
            
            <a href="{{ route('wallet.balance') }}" class="menu-box">
                <span class="menu-title">Wallet Balance</span>
            </a>

            <a href="{{ route('bookings.index') }}" class="menu-box">
                <span class="menu-title">My Bookings</span>
            </a>

            <a href="{{ route('helpcenter.index') }}" class="menu-box">
                <span class="menu-title">Help Center</span>
            </a>

        </section>

        @if(Auth::user()->email === 'developer@gmail.com')
            <section class="dev-section">
                <h3>🛠️ Developer Control Panel</h3>
                <div class="dev-grid">
                    <a href="{{ url('/promos/create') }}" class="btn-dev">Create New Promo</a>
                    <a href="{{ url('/promos') }}" class="btn-dev">View Promo List</a>
                </div>
            </section>
        @endif

    </main>

</body>
</html>
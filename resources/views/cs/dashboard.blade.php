<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Dashboard</title>
    @vite(['resources/css/dashboard.css'])
</head>
<body>

    <header class="navbar">
        <div class="navbar-brand">RideApp - CS Portal</div>
        <div class="navbar-user-zone">
            <span class="user-greeting">Hi, {{ Auth::guard('cs')->user()->name }} 🎧</span>
            
            <form method="POST" action="/logout-cs" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">LOGOUT</button>
            </form>
        </div>
    </header>

    <main class="dashboard-container">
        
        <div class="welcome-banner">
            <h2>CS Dashboard</h2>
            <p>Welcome our beloved CS 😍 Select a management panel below.</p>
        </div>

        <section class="menu-grid">
            
            <a href="{{ route('cs.users') }}" class="menu-box">
                <span class="menu-title">User Management</span>
            </a>

        </section>

    </main>

</body>
</html>
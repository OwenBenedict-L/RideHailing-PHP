<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ride App</title>
    @vite(['resources/css/landing.css'])
</head>
<body>

    <div class="top-bar">
        <div class="partner-block">
            <span>Drive with Us! 🚗</span>
            <a href="/login-driver" class="btn btn-solid">Login Driver</a>
            <a href="/register-driver" class="btn btn-outline">Sign Up</a>
        </div>
        
        <div class="partner-block">
            <span>Support Team 🎧</span>
            <a href="/login-cs" class="btn btn-solid">Login CS</a>
        </div>
    </div>

    <div class="main-screen">
        
        <div class="profile-section">
            <h1>Welcome to Ride App!</h1>
            <p>An easy and safe way to get around every day. Book your ride anytime and enjoy a comfortable trip.</p>
        </div>

        <div class="user-box">
            <h3>Start Riding Today</h3>
            <a href="/login-user" class="btn btn-user-login">Login as User</a>
            <a href="/register-user" class="btn btn-user-register">Create User Account</a>
        </div>

    </div>
</body>
</html>
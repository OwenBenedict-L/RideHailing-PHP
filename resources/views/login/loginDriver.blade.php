<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Driver</title>
    
    @vite(['resources/css/login.css'])
</head>
<body>

    <div class="login-box">
        <a href="/" class="btn-back">← BACK</a>

        <div class="login-header">
            <h2>LOGIN DRIVER</h2>
        </div>
        
        @if (session('success'))
            <div class="alert-success">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any()) 
            <div class="error-alert"> 
                <strong>Error!</strong> {{ $errors->first('email') }} 
            </div> 
        @endif 
     
        <form method="POST" action="/login-driver"> 
            @csrf 
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
     
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
     
            <button type="submit" class="btn-submit">LOGIN AS DRIVER</button> 
        </form> 
        
        <a href="/register-driver" class="register-link">Don't have an account? Sign Up</a>
    </div>

</body> 
</html>
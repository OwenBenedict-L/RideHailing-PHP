<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    
    @vite(['resources/css/register.css', 'resources/js/register.js'])
</head>
<body>

    <div class="register-box">
        <a href="/" class="btn-back">← BACK</a>

        <div class="register-header">
            <h2>REGISTER USER</h2>
        </div>

        @if ($errors->any()) 
            <div class="error-alert"> 
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><strong>Error!</strong> {{ $error }}</li>
                    @endforeach
                </ul>
            </div> 
        @endif 

        <form method="POST" action="/register-user"> 
            @csrf 
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
            </div>
     
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required>
            </div>
     
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
            </div>
     
            <button type="submit" class="btn-submit">SIGN UP AS USER</button> 
        </form> 
    </div>

</body> 
</html>
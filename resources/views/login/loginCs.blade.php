<html> 
<body> 
    <h2>Login Page Customer Service</h2> 
 
    @if ($errors->any()) 
        <div style="color: red;"> 
            <strong>Error!</strong> {{ $errors->first('email') }} 
        </div> <br> 
    @endif 
 
    <form method="POST" action="/login-cs"> 
        @csrf 
        <label>Email:</label><br> 
        <input type="email" name="email" value="{{ old('email') }}" required><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password" required><br><br> 
 
        <button type="submit">LOGIN CS</button> 
    </form> 
    <br>
    <a href="/register-cs">Don't have an account? [sign up]</a>
    <br>
    <a href="/">[BACK]</a>
</body> 
</html>
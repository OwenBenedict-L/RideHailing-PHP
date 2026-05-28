<html> 
<body> 
    <h2>Login Page Driver</h2> 
 
    @if ($errors->any()) 
        <div style="color: red;"> 
            <strong>Error!</strong> {{ $errors->first('email') }} 
        </div> <br> 
    @endif 
 
    <form method="POST" action="/login-driver"> 
        @csrf 
        <label>Email:</label><br> 
        <input type="email" name="email"><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password"><br><br> 
 
        <button type="submit">LOGIN DRIVER</button> 
    </form> 
    <br>
    <a href="/register-driver">Don't have an account? [sign up]</a>
    <br>
    <a href="/">[BACK]</a>
</body> 
</html>
<html> 
<body> 
    <h2>Login Page</h2> 
 
    @if ($errors->any()) 
        <div style="color: red;"> 
            <strong>Error!</strong> {{ $errors->first('email') }} 
        </div> <br> 
    @endif 
 
    <form method="POST" action="/login"> 
        @csrf 
        <label>Email:</label><br> 
        <input type="email" name="email"><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password"><br><br> 
 
        <button type="submit">LOGIN</button> 
    </form> 
    <br>
    <a href="/register">Don't have an account? [sign up]</a>
</body> 
</html>
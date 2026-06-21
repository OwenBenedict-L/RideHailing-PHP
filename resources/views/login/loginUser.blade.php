<html> 
<body> 
    <table>
    <tr>
        <th style="border: none">
            <h2>
                <a href="/">
                    <button type="button">BACK</button>
                </a>
            </h2>
        </th>

        <th style="border: none">
            <h2>LOGIN PAGE USER</h2>  
        </th>
    </tr>
    </table>
 
    @if ($errors->any()) 
        <div style="color: red;"> 
            <strong>Error!</strong> {{ $errors->first('email') }} 
        </div> <br> 
    @endif 
 
    <form method="POST" action="/login-user"> 
        @csrf 
        <label>Email:</label><br> 
        <input type="email" name="email" value = "{{old('email')}}" required><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password"><br><br> 
 
        <button type="submit">LOGIN USER</button> 
    </form> 
    <br>
    <a href="/register-user">Don't have an account? SIGN UP</a>
</body> 
</html>
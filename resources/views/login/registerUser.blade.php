<html> 
<body> 
    <h2>REGISTER USER</h2> 

    @if ($errors->any()) 
        <div style="color: red;"> 
            <ul>
                @foreach ($errors->all() as $error)
                    <li><strong>Error!</strong> {{ $error }}</li>
                @endforeach
            </ul>
        </div> 
        <br> 
    @endif 

    <form method="POST" action="/register-user"> 
        @csrf 
        <label>Full Name:</label><br> 
        <input type="text" name="name" required><br><br> 

        <label>Email:</label><br> 
        <input type="email" name="email" value="{{ old('email') }}" required><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password" required><br><br> 
 
        <button type="submit">[SIGN UP AS USER]</button> 
    </form> 
    <br>
    <a href="/">[BACK]</a>
</body> 
</html>
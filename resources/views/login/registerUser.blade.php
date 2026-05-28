<html> 
<body> 
    <h2>REGISTER USER</h2> 
    <form method="POST" action="/register-user"> 
        @csrf 
        <label>Full Name:</label><br> 
        <input type="text" name="name" required><br><br> 

        <label>Email:</label><br> 
        <input type="email" name="email" required><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password" required><br><br> 
 
        <button type="submit">[SIGN UP AS USER]</button> 
    </form> 
    <br>
    <a href="/login-user">[BACK TO LOGIN]</a>
</body> 
</html>
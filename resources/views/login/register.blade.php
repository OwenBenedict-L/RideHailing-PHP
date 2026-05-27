<html> 
<body> 
    <h2>REGISTER</h2> 
    <form method="POST" action="/register"> 
        @csrf 
        <label>Full Name:</label><br> 
        <input type="text" name="name" required><br><br> 

        <label>Email:</label><br> 
        <input type="email" name="email" required><br><br> 
 
        <label>Password:</label><br> 
        <input type="password" name="password" required><br><br> 

        <label>Register As:</label><br> 
        <select name="role">
            <option value="user">User / Penumpang</option>
            <option value="driver">Driver</option>
        </select><br><br>
 
        <button type="submit">[SIGN UP]</button> 
    </form> 
    <br>
    <a href="/login">[BACK]</a>
</body> 
</html>
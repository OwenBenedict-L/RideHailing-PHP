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

        <label>Drivers License Number:</label><br>
        <input type="text" name="drivers_license_number" required><br><br> 

        <label>Drivers Plate:</label><br>
        <input type="text" name="license_plate" required><br><br> 
 
        <button type="submit">[SIGN UP]</button> 
    </form> 
    <br>
    <a href="/login">[BACK]</a>
</body> 
</html>
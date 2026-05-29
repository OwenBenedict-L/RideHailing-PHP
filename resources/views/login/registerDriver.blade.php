<html> 
<body> 
    <h2>REGISTER DRIVER</h2> 

    @if ($errors->any()) 
        <div style="color: red;"> 
            <ul>
                @foreach ($errors->all() as $error)
                    <li><strong>Error!</strong> {{ $error }}</li>
                @endforeach
            </ul>
        </div> <br> 
    @endif
    
    <form method="POST" action="/register-driver"> 
        @csrf 
        <label>Full Name:</label><br> 
        <input type="text" name="name" required><br><br> 

        <label>Email:</label><br> 
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>
 
        <label>Password:</label><br> 
        <input type="password" name="password" required><br><br> 

        <label>Drivers License Number:</label><br>
        <input type="text" name="drivers_license_number" value="{{ old('drivers_license_number') }}" required><br><br>

        <label>Drivers Plate:</label><br>
        <input type="text" name="license_plate" value="{{ old('license_plate') }}" required><br><br>
 
        <button type="submit">[SIGN UP AS DRIVER]</button> 
    </form> 
    <br>
    <a href="/">[BACK]</a>
</body> 
</html>
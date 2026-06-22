<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Driver</title>
    
    @vite(['resources/css/register.css'])
</head>
<body>

    <div class="register-box">
        <a href="/" class="btn-back">← BACK</a>

        <div class="register-header">
            <h2>REGISTER DRIVER</h2>
        </div>

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

        <label>Confirm Password:</label><br> 
        <input type="password" name="password_confirmation" required><br><br> 

        <label>Drivers License Number:</label><br>
        <input type="text" name="drivers_license_number" value="{{ old('drivers_license_number') }}" required><br><br>

        
        <label>Vehicle Type:</label><br>
        <select name="vehicle_type_id" required>
            <option value="">Select Vehicle Type</option>
            @foreach($vehicleTypes as $type)
                <option value="{{ $type->id }}" {{ old('vehicle_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->display_name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Drivers Plate:</label><br>
        <input type="text" name="license_plate" value="{{ old('license_plate') }}" required><br><br>
 
        <button type="submit">SIGN UP AS DRIVER</button> 
    </form> 
</body> 
</html>
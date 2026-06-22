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
            <h2>REGISTER DRIVER</h2> 
        </th>
    </tr>
    </table>

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
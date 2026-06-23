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
        </div>
    @endif
    
    <form method="POST" action="/register-driver"> 
        @csrf 
        <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name">
        </div>

        <div class="form-group">
            <label>Email:</label> 
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label>Drivers License Number:</label>
            <input type="text" name="drivers_license_number" value="{{ old('drivers_license_number') }}" autocomplete="off"required>
        </div>

        <div class="form-group">
            <label>Vehicle Type:</label>
            
                <select id="vehicle_type_id" name="vehicle_type_id" required>
                    <option value="" disabled {{ old('vehicle_type_id') ? '' : 'selected' }}>Select Vehicle Type</option>
                        @foreach($vehicleTypes as $type)
                            <option value="{{ $type->id }}" {{ old('vehicle_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->display_name }}
                            </option>
                        @endforeach
                </select>
        </div>

        <div class="form-group">
            <label>Drivers Plate:</label>
            <input type="text" name="license_plate" value="{{ old('license_plate') }}" autocomplete="off"required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>
        </div>
     
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
        </div>
 
        <button type="submit" class="btn-submit">SIGN UP AS DRIVER</button> 
    </form> 
</body> 
</html>
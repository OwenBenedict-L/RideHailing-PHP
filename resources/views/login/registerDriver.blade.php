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
            <div class="error-alert"> 
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
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
            </div>
     
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required>
            </div>
     
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
            </div>

            <div class="form-group">
                <label for="drivers_license_number">Drivers License Number (SIM)</label>
                <input type="text" id="drivers_license_number" name="drivers_license_number" value="{{ old('drivers_license_number') }}" required>
            </div>

            <div class="form-group">
                <label for="license_plate">Drivers Plate (Police Number)</label>
                <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required>
            </div>
     
            <button type="submit" class="btn-submit">SIGN UP AS DRIVER</button> 
        </form> 
    </div>

</body> 
</html>
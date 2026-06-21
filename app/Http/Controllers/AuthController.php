<?php 
namespace App\Http\Controllers; 
 
use App\Models\User;
use App\Models\Driver;
use App\Models\Cs;
use App\Models\UserNotification;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller 
{ 
    public function showLoginUser() { 
        return view('login.loginUser'); 
    } 

    public function showRegisterUser() { 
        return view('login.registerUser'); 
    }

    public function registerUser(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ], [
            'email.unique' => 'This email is already registered, please use another email!',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('user')->login($user);

        UserNotification::create([
            'user_id' => $user->id,
            'type' => 'system',
            'title' => 'Welcome!🎉',
            'message' => 'Hello ' . $user->name . ', your account has been successfully created. Your account has been successfully created. Book rides anytime and enjoy a safe, convenient, and reliable travel experience!',
            'is_read' => false
        ]);

        return redirect('/dashboard-user');
    }

    public function loginUser(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]); 
 
        if (Auth::guard('user')->attempt($credentials)) { 
            $request->session()->regenerate(); 

            UserNotification::create([
                'user_id' => Auth::guard('user')->id(),
                'type' => 'security',
                'title' => 'New Login Detected ⚠️',
                'message' => 'Your account was successfully logged in on ' . now()->format('d M Y, H:i') . ' WIB. If this wasn\'t you, please secure your password immediately.',
                'is_read' => false
            ]);

            return redirect()->intended('/dashboard-user'); 
        } 
 
        return back()->withErrors([
            'email' => 'Wrong email or password.'])->withInput($request->only('email')); 
    } 

    public function dashboardUser() {
        return view('login.dashboardUser');
    }

    public function showLoginDriver() { 
        return view('login.loginDriver'); 
    }

    public function showRegisterDriver() { 
        return view('login.registerDriver'); 
    }

    public function registerDriver(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:drivers',
            'password' => 'required|confirmed',
            'drivers_license_number' => 'required|unique:drivers',
            'license_plate' => 'required|unique:drivers',
        ],[
            'email.unique' => 'This driver email is already registered!',
            'password.confirmed' => 'The password confirmation does not match.',
            'drivers_license_number.unique' => 'This drivers license number is already registered in our system!',
            'license_plate.unique' => 'This license plate is already used by another driver!',
        ]);

        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'drivers_license_number' => $request->drivers_license_number,
            'license_plate' => $request->license_plate,
        ]);

        Auth::guard('driver')->login($driver);
        return redirect('/dashboard-driver');
    }

    public function loginDriver(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]); 
 
        if (Auth::guard('driver')->attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended('/dashboard-driver'); 
        } 
 
        return back()->withErrors([
            'email' => 'Wrong email or password.'])->withInput($request->only('email')); 
    } 

    public function dashboardDriver() {
        return view('login.dashboardDriver');
    }

    public function showLoginCs() { 
        return view('login.loginCs'); 
    }

    public function showRegisterCs() { 
        return view('login.registerCs'); 
    }

    public function registerCs(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cs,email',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'email.unique' => 'This email is already registered for a CS account!',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $cs = Cs::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('cs')->login($cs);
        return redirect('/cs/dashboard'); 
    }

    public function loginCs(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]); 
 
        if (Auth::guard('cs')->attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended('/cs/dashboard'); 
        } 
 
        return back()->withErrors([
            'email' => 'Wrong email or password.'])->withInput($request->only('email')); 
    }

    public function logout(Request $request) {
        if (Auth::guard('driver')->check()) {
            Auth::guard('driver')->logout();
        } elseif (Auth::guard('cs')->check()) {
            Auth::guard('cs')->logout();
        } else {
            Auth::guard('user')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
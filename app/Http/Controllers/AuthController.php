<?php 
namespace App\Http\Controllers; 
 
use App\Models\User;
use App\Models\Driver;
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
            'password' => 'required',
        ], [
            'email.unique' => 'This email is already registered, please use another email!',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('user')->login($user);
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
            return redirect()->intended('/dashboard-user'); 
        } 
 
        return back()->withErrors(['email' => 'Wrong email or password.']); 
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
            'password' => 'required',
            'drivers_license_number' => 'required|unique:drivers',
            'license_plate' => 'required|unique:drivers',
        ],[
            'email.unique' => 'This driver email is already registered!',
            'drivers_license_number.unique' => 'This drivers license number is already registered in our system!',
            'license_plate.unique' => 'This license plate is already used by another driver!',
        ]);

        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
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
 
        return back()->withErrors(['email' => 'Wrong email or password.']); 
    } 

    public function dashboardDriver() {
        return view('login.dashboardDriver');
    }

    public function logout(Request $request) {
        if (Auth::guard('driver')->check()) {
            Auth::guard('driver')->logout();
        } else {
            Auth::guard('user')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
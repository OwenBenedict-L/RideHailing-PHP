<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller 
{ 
    public function showLogin() 
    { 
        return view('login.login'); 
    } 

    public function showRegister() { 
        return view('login.register'); 
    }

    public function showRegisterDriver() { 
        return view('login.registerDriver'); 
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => $request->role,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }

    public function registerDriver(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'role' => 'required',
            'drivers_license_number' => 'required|drivers_license_number|unique:drivers',
            'license_plate' => 'required|license_plate|unique:drivers',
        ]);

        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'drivers_license_number' => $request->drivers_license_number,
            'license_plate' => $request->license_plate,
            // 'role' => $request->role,
        ]);

        Auth::login($driver);
        return redirect('/dashboardDriver');
    }
 
    public function login(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]); 
 
        if (Auth::attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended('/dashboard'); 
        } 
 
        return back()->withErrors([ 
            'email' => 'Wrong email or password.', 
        ]); 
    } 

    public function dashboard() {
        // if (Auth::Driver()) {
        //     return view('login.dashboardDriver');
        // }
        return view('login.dashboardUser');
    }

    public function dashboardDriver() {
        return view('login.dashboardDriver');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 
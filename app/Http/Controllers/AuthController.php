<?php 
 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
 
class AuthController extends Controller 
{ 
    public function showLogin() 
    { 
        return view('login.login'); 
    } 

    public function showRegister() { 
        return view('login.register'); 
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
 
    public function login(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => ['required', 'email'], 
            'password' => ['required'], 
        ]); 
 
        if (Auth::attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended('/posts'); 
        } 
 
        return back()->withErrors([ 
            'email' => 'Wrong email or password.', 
        ]); 
    } 

    public function dashboard() {
        if (Auth::user()->role === 'driver') {
            return view('login.dashboarDriver');
        }
        return view('login.dashboardUser');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 
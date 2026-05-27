<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('login.landing');
});

Route::get('/vulnerable', function () { 
$name = request('name'); 
$user = DB::select("SELECT * FROM users WHERE name = ?", [$name]); 
return $user; 
}); 

Route::middleware('guest')->group(function() { 
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/registerDriver', [AuthController::class, 'showRegisterDriver']);
    Route::post('/registerDriver', [AuthController::class, 'registerDriver']);
}); 

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.balance');
    Route::resource('bookings', BookingController::class);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 

Route::post('/login', [AuthController::class, 'login']);

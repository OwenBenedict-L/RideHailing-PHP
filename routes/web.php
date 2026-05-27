<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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
}); 

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 

Route::post('/login', [AuthController::class, 'login']);
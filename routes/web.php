<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\EstimationController;

Route::get('/', function () {
    return view('login.landing');
});

Route::get('/vulnerable', function () { 
    $name = request('name'); 
    $user = DB::select("SELECT * FROM users WHERE name = ?", [$name]); 
    return $user; 
}); 

Route::middleware('guest')->group(function() { 
    Route::get('/login-user', [AuthController::class, 'showLoginUser'])->name('login'); // Name 'login' wajib untuk User agar sistem Auth Laravel tidak bingung
    Route::post('/login-user', [AuthController::class, 'loginUser']);
    Route::get('/register-user', [AuthController::class, 'showRegisterUser']);
    Route::post('/register-user', [AuthController::class, 'registerUser']);

    Route::get('/login-driver', [AuthController::class, 'showLoginDriver']);
    Route::post('/login-driver', [AuthController::class, 'loginDriver']);
    Route::get('/register-driver', [AuthController::class, 'showRegisterDriver']);
    Route::post('/register-driver', [AuthController::class, 'registerDriver']);
}); 

Route::middleware('auth:user')->group(function () {
    Route::get('/dashboard-user', [AuthController::class, 'dashboardUser'])->name('dashboard.user');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.balance');
    Route::get('/wallet/topup', [WalletController::class, 'topupForm'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    Route::post('/bookings/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::resource('bookings', BookingController::class);
});

Route::middleware('auth:driver')->group(function () {
    Route::get('/dashboard-driver', [AuthController::class, 'dashboardDriver'])->name('dashboard.driver');
});

Route::middleware('auth:user,driver')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/estimations/create', [EstimationController::class, 'create'])->name('estimations.create');
Route::post('/estimations', [EstimationController::class, 'store'])->name('estimations.store');
Route::get('/estimations/{id}', [EstimationController::class, 'show'])->name('estimations.show');

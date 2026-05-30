<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DriverWalletController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\HelpCenterController;

Route::get('/', function () {
    if (Auth::guard('user')->check()) {
        return redirect('/dashboard-user');
    }
    
    if (Auth::guard('driver')->check()) {
        return redirect('/dashboard-driver');
    }

    return view('login.landing');
});

Route::get('/vulnerable', function () { 
    $name = request('name'); 
    $user = DB::select("SELECT * FROM users WHERE name = ?", [$name]); 
    return $user; 
}); 

Route::middleware('guest:user')->group(function() { 
    Route::get('/login-user', [AuthController::class, 'showLoginUser'])->name('login'); 
    Route::post('/login-user', [AuthController::class, 'loginUser']);
    Route::get('/register-user', [AuthController::class, 'showRegisterUser']);
    Route::post('/register-user', [AuthController::class, 'registerUser']);
});

Route::middleware('guest:driver')->group(function() {
    Route::get('/login-driver', [AuthController::class, 'showLoginDriver']);
    Route::post('/login-driver', [AuthController::class, 'loginDriver']);
    Route::get('/register-driver', [AuthController::class, 'showRegisterDriver']);
    Route::post('/register-driver', [AuthController::class, 'registerDriver']);
}); 

Route::middleware('auth:user')->group(function () {
    Route::get('/dashboard-user', [AuthController::class, 'dashboardUser'])->name('dashboard.user');
    Route::post('/logout-user', [AuthController::class, 'logout']);
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.balance');
    Route::get('/wallet/topup', [WalletController::class, 'topupForm'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    Route::post('/bookings/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::resource('bookings', BookingController::class);
    Route::get('/estimations/create', [EstimationController::class, 'create'])->name('estimations.create');
    Route::post('/estimations', [EstimationController::class, 'store'])->name('estimations.store');
    Route::get('/estimations/{id}', [EstimationController::class, 'show'])->name('estimations.show');
    Route::get('/helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');
    Route::post('/helpcenter', [HelpCenterController::class, 'store'])->name('helpcenter.store');
    Route::get('/helpcenter/history', [HelpCenterController::class, 'history'])->name('helpcenter.history');
});

Route::middleware('auth:driver')->group(function () {
    Route::get('/dashboard-driver', [AuthController::class, 'dashboardDriver'])->name('dashboard.driver');
    Route::post('/logout-driver', [AuthController::class, 'logout']);
    Route::get('/driver/wallet', [DriverWalletController::class, 'index'])->name('driver.wallet.balance');
    Route::get('/driver/orders', [BookingController::class, 'driverOrders'])->name('driver.orders');
    Route::post('/driver/bookings/{booking}/accept', [BookingController::class, 'acceptOrder'])->name('bookings.orders.accept');
    Route::post('/driver/bookings/{booking}/reject', [BookingController::class, 'rejectOrder'])->name('bookings.orders.reject');
});

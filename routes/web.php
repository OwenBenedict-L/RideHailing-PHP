<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DriverWalletController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DriverNotificationController;

Route::get('/', function () {
    if (Auth::guard('user')->check()) {
        return redirect('/dashboard-user');
    }
    
    if (Auth::guard('driver')->check()) {
        return redirect('/dashboard-driver');
    }
    if (Auth::guard('cs')->check()) {
        return redirect('/cs/dashboard');
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

Route::middleware('guest:cs')->group(function() {
    Route::get('/login-cs', [AuthController::class, 'showLoginCs'])->name('cs.login');
    Route::post('/login-cs', [AuthController::class, 'loginCs'])->name('cs.login.submit');
    Route::get('/register-cs', [AuthController::class, 'showRegisterCs'])->name('cs.register');
    Route::post('/register-cs', [AuthController::class, 'registerCs'])->name('cs.register.submit');
});

Route::middleware('auth:user')->group(function () {
    Route::get('/dashboard-user', [AuthController::class, 'dashboardUser'])->name('dashboard.user');
    Route::post('/logout-user', [AuthController::class, 'logout']);
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.balance');
    Route::get('/wallet/topup', [WalletController::class, 'topupForm'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    Route::get('/wallet/history', [WalletController::class, 'history'])->name('wallet.history');
    Route::post('/bookings/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::get('/bookings/checkout', [EstimationController::class, 'checkout'])->name('bookings.checkout');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/estimations/create', [EstimationController::class, 'create'])->name('estimations.create');
    Route::post('/estimations', [EstimationController::class, 'store'])->name('estimations.store');
    Route::get('/estimations/detail', [EstimationController::class, 'show'])->name('estimations.show');
    Route::post('/estimations/select', [EstimationController::class, 'selectVehicle'])->name('estimations.selectVehicle');
    Route::get('/helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');
    Route::post('/helpcenter', [HelpCenterController::class, 'store'])->name('helpcenter.store');
    Route::get('/helpcenter/history', [HelpCenterController::class, 'history'])->name('helpcenter.history');
    Route::get('/helpcenter/chat/{id}', [HelpCenterController::class, 'chat'])->name('helpcenter.chat');
    Route::post('/helpcenter/chat/{id}', [HelpCenterController::class, 'sendReply'])->name('helpcenter.reply');
    Route::get('/helpcenter/feedback', [HelpCenterController::class, 'feedbackPage'])->name('helpcenter.feedback');
    Route::get('/promos/create', [PromoController::class, 'create']);
    Route::get('/promos', [PromoController::class, 'index']);
    Route::post('/promos', [PromoController::class, 'store']);
    Route::post('/promos/validate', [PromoController::class, 'validatePromo']);
    Route::delete('/promos/{id}', [PromoController::class, 'destroy']);
    Route::get('/chat/user/{chatId}', [ChatController::class, 'showConversationForUser'])->name('chat.show.user');
    Route::post('/chat/user/{chatId}', [ChatController::class, 'storeForUser'])->name('chat.send.user');
    Route::post('/chat/update-user/{chatId}', [ChatController::class, 'updateChatUser'])->name('chat.update.user');
    Route::delete('/chat/delete-user/{chatId}', [ChatController::class, 'deleteChatUser'])->name('chat.delete.user');
    Route::post('/notifications/mark-all-read', [UserNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/delete-all', [UserNotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [UserNotificationController::class, 'show'])->name('notifications.show');
    Route::put('/notifications/{id}', [UserNotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{id}', [UserNotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/bookings/{booking}/review/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/bookings/{booking}/review', [ReviewController::class, 'update'])->name('reviews.update');
});

Route::middleware('auth:driver')->group(function () {
    Route::get('/dashboard-driver', [AuthController::class, 'dashboardDriver'])->name('dashboard.driver');
    Route::post('/logout-driver', [AuthController::class, 'logout']);
    Route::get('/driver/wallet', [DriverWalletController::class, 'index'])->name('driver.wallet.balance');
    Route::get('/driver/wallet/withdraw', [DriverWalletController::class, 'withdrawForm'])->name('driver.wallet.withdraw');
    Route::post('/driver/wallet/withdraw', [DriverWalletController::class, 'processWithdraw'])->name('driver.wallet.withdraw.process');
    Route::get('/driver/wallet/history', [DriverWalletController::class, 'history'])->name('driver.wallet.history');
    Route::get('/driver/orders', [BookingController::class, 'driverOrders'])->name('driver.orders');
    Route::post('/driver/bookings/{booking}/accept', [BookingController::class, 'acceptOrder'])->name('bookings.orders.accept');
    Route::post('/driver/bookings/{booking}/reject', [BookingController::class, 'rejectOrder'])->name('bookings.orders.reject');
    Route::patch('/driver/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.orders.update');
    Route::get('/chat/driver/{chatId}', [ChatController::class, 'showConversationForDriver'])->name('chat.show.driver');
    Route::post('/chat/driver/{chatId}', [ChatController::class, 'storeForDriver'])->name('chat.send.driver'); 
    Route::post('/chat/update-driver/{chatId}', [ChatController::class, 'updateChatDriver'])->name('chat.update.driver');
    Route::post('/chat/delete-driver/{chatId}', [ChatController::class, 'deleteChatDriver'])->name('chat.delete.driver');
    Route::post('/driver-notifications/mark-all-read', [DriverNotificationController::class, 'markAllRead'])->name('driver-notifications.markAllRead');
    Route::delete('/driver-notifications/delete-all', [DriverNotificationController::class, 'deleteAll'])->name('driver-notifications.deleteAll');
    Route::get('/driver-notifications', [DriverNotificationController::class, 'index'])->name('driver-notifications.index');
    Route::get('/driver-notifications/{driverNotification}', [DriverNotificationController::class, 'show'])->name('driver-notifications.show');
    Route::put('/driver-notifications/{driverNotification}', [DriverNotificationController::class, 'update'])->name('driver-notifications.update');
    Route::delete('/driver-notifications/{driverNotification}', [DriverNotificationController::class, 'destroy'])->name('driver-notifications.destroy');
    
 Route::get('/driver/helpcenter', [HelpCenterController::class, 'index'])->name('driver.helpcenter.index');
    Route::post('/driver/helpcenter', [HelpCenterController::class, 'store'])->name('driver.helpcenter.store');
    Route::get('/driver/helpcenter/history', [HelpCenterController::class, 'history'])->name('driver.helpcenter.history');
    Route::get('/driver/helpcenter/chat/{id}', [HelpCenterController::class, 'chat'])->name('driver.helpcenter.chat');
    Route::post('/driver/helpcenter/chat/{id}', [HelpCenterController::class, 'sendReply'])->name('driver.helpcenter.sendReply');
    Route::get('/driver/helpcenter/feedback', [HelpCenterController::class, 'feedbackPage'])->name('driver.helpcenter.feedback');
});

Route::middleware('auth:cs')->group(function () {
    Route::get('/cs/dashboard', [CsController::class, 'dashboard'])->name('cs.dashboard');
    Route::get('/cs/users', [CsController::class, 'users'])->name('cs.users');
    Route::get('/cs/ticket/{id}/chat', [CsController::class, 'chat'])->name('cs.chat');
    Route::post('/cs/ticket/{id}/reply', [CsController::class, 'reply'])->name('cs.reply');
    Route::post('/cs/ticket/{id}/complete', [CsController::class, 'complete'])->name('cs.ticket.complete');
    Route::post('/logout-cs', [AuthController::class, 'logout'])->name('cs.logout');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes (authentication)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Password change
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}/book', [RoomController::class, 'showBookingForm'])->name('rooms.book');
    
    // Bookings
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Routes
// In routes/web.php

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Room Management
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rooms', [App\Http\Controllers\Admin\RoomController::class, 'index'])->name('rooms.index'); // <-- ADD THIS (List)
    Route::get('/rooms/create', [App\Http\Controllers\Admin\RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [App\Http\Controllers\Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}/edit', [App\Http\Controllers\Admin\RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [App\Http\Controllers\Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('rooms.destroy'); // <-- ADD THIS (Delete)

});
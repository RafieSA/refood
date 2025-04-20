<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

// Frontend routes (User)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [App\Http\Controllers\RestaurantController::class, 'index'])->name('frontend.home');
    Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurants.index');
});

// Default login route (required by Laravel for redirect)
Route::get('login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Admin routes
Route::prefix('admin')->group(function () {
    // Admin login route
    Route::get('login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');

    // Protected admin routes
    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD routes for restaurants
        Route::resource('restaurants', App\Http\Controllers\Admin\RestaurantController::class);
    });
});
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;      // ← tambahkan ini


// Frontend routes (User)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [App\Http\Controllers\RestaurantController::class, 'index'])->name('frontend.home');
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('frontend.restaurants.index');
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
});

Route::resource('restaurants', RestaurantController::class);



// Default login route (required by Laravel for redirect)
Route::get('login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware([
        'auth:admins',
        \App\Http\Middleware\IsAdmin::class,  // ← pakai FQCN di sini
    ])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        // CRUD restaurants
        Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantController::class);

        // CRUD profile admin
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    });
    
});

Route::prefix('super-admin')->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\SuperAdminLoginController::class, 'showLoginForm'])->name('super_admin.login');
    Route::post('login', [\App\Http\Controllers\Auth\SuperAdminLoginController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Auth\SuperAdminLoginController::class, 'logout'])->name('super_admin.logout');
});

Route::prefix('super-admin')->middleware(['auth:super_admins'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\SuperAdminDashboardController::class, 'index'])->name('super_admin.dashboard');
    Route::resource('admins', \App\Http\Controllers\Admin\SuperAdminController::class);
});


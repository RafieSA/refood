<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\ComentController;
use App\Http\Controllers\Admin\VoucherClaimController;

// Frontend routes (User) yang bisa diakses tanpa login
Route::get('/', [RestaurantController::class, 'index'])->name('frontend.home');

// Redirect /restaurants to / to avoid duplicate content (SEO optimization)
Route::redirect('/restaurants', '/', 301)->name('frontend.restaurants.index');
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('frontend.restaurants.show');
Route::get('/restaurants/{id}/claim', [RestaurantController::class, 'showClaimForm'])->name('frontend.restaurants.claim');
Route::post('/restaurants/{id}/claim', [RestaurantController::class, 'submitClaimForm'])->name('frontend.restaurants.claim.submit');
Route::get('/customer-service', function () {
    return view('customer-service');
})->name('customer.service');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('frontend.articles.show');
Route::get('/restaurants/{id}/about', [RestaurantController::class, 'about'])->name('frontend.restaurants.about');
Route::get('/restaurants/{id}/map', [RestaurantController::class, 'map'])->name('frontend.restaurants.map');

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
        \App\Http\Middleware\IsAdmin::class,
    ])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // CRUD restaurants dengan route names yang benar
        Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantController::class)->names([
            'index' => 'admin.restaurants.index',
            'create' => 'admin.restaurants.create',
            'store' => 'admin.restaurants.store',
            'show' => 'admin.restaurants.show',
            'edit' => 'admin.restaurants.edit',
            'update' => 'admin.restaurants.update',
            'destroy' => 'admin.restaurants.destroy',
        ]);

        // CRUD profile admin
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
        
        // Kelola Data Klaim Voucher
        Route::get('voucher-claims', [VoucherClaimController::class, 'index'])->name('admin.voucher.claims.index');
        Route::delete('voucher-claims/{id}', [VoucherClaimController::class, 'destroy'])->name('admin.voucher.claims.destroy');
        Route::put('voucher-claims/{id}/status', [VoucherClaimController::class, 'updateStatus'])->name('admin.voucher.claims.updateStatus');
        Route::get('voucher-claims/{id}', [VoucherClaimController::class, 'show'])->name('admin.voucher.claims.show');
        Route::post('voucher-claims/{id}/approve', [VoucherClaimController::class, 'approve'])->name('admin.voucher.claims.approve');
        Route::post('voucher-claims/{id}/reject', [VoucherClaimController::class, 'reject'])->name('admin.voucher.claims.reject');
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
    Route::resource('restaurants', \App\Http\Controllers\Admin\RestaurantController::class); // Tambahkan ini
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
});

Route::post('/coments', [ComentController::class, 'store'])->name('coments.store');


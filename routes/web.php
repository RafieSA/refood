<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController; // ← tambahkan ini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// route publik yang menampilkan data restoran
Route::get('/restaurants', [RestaurantController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

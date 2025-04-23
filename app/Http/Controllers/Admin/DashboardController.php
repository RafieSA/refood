<?php
// filepath: d:\Kuliah\Semester 6\ppl-refood\SI4605-KEL411\app\Http\Controllers\Admin\DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRestaurants = Restaurant::count();
        $activeDiscounts = DB::table('restaurants')->whereNotNull('discount')->count();
        $totalAdmins = DB::table('admins')->count(); // Menggunakan tabel admins

        return view('admin.dashboard', compact('totalRestaurants', 'activeDiscounts', 'totalAdmins'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $adminId = auth()->guard('admins')->id();

        // Statistik berdasarkan admin_id
        $totalRestaurants = Restaurant::where('admin_id', $adminId)->count();
        $activeDiscounts = Restaurant::where('admin_id', $adminId)->where('discount_percentage', '>', 0)->count();

        return view('admin.dashboard', compact('totalRestaurants', 'activeDiscounts'));
    }
}
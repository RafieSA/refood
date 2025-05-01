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
        $totalRestaurants = Restaurant::count();
        $activeDiscounts = Restaurant::where('discount_percentage', '>', 0)->count();
        $totalAdmins = Admin::count();
        
        return view('admin.dashboard', compact('totalRestaurants', 'activeDiscounts', 'totalAdmins'));
    }
}
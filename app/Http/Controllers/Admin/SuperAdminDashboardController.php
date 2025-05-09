<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Restaurant;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua admin restaurant
        $admins = Admin::all();

        // Ambil semua restoran
        $restaurants = Restaurant::all();

        return view('admin.super_admins.dashboard', compact('admins', 'restaurants'));
    }
}

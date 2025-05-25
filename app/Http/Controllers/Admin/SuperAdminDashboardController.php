<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\Article;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::all();

        // Tambahkan pencarian restaurant
        $restaurantSearch = $request->input('restaurant_search');
        $restaurants = \App\Models\Restaurant::with('admin')
            ->when($restaurantSearch, function ($query, $restaurantSearch) {
                $query->where('food_name', 'ilike', "%{$restaurantSearch}%")
                      ->orWhere('address', 'ilike', "%{$restaurantSearch}%")
                      ->orWhereHas('admin', function ($q) use ($restaurantSearch) {
                          $q->where('Restaurant_Name', 'ilike', "%{$restaurantSearch}%");
                      });
            })
            ->get();

        $search = $request->input('search');
        $articles = Article::when($search, function ($query, $search) {
            $query->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
        })->orderBy('uploaded_at', 'desc')->get();

        return view('admin.super_admins.dashboard', compact('admins', 'restaurants', 'articles', 'search', 'restaurantSearch'));
    }
}

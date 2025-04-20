<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    // Menampilkan semua restoran
    public function index()
    {
        $restaurants = Restaurant::all();
        return response()->json($restaurants);
    }
}

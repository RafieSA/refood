<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    // Menampilkan semua restoran
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('restaurants.index', compact('restaurants'));
    }

    public function show($id)
    {
    // Ambil data dari Supabase
    $response = Http::get(env('SUPABASE_URL') . '/rest/v1/restaurants', [
        'id' => 'eq.' . $id,
        'apikey' => env('SUPABASE_KEY'),
    ]);

    $restaurant = $response->json()[0] ?? null;

    if (!$restaurant) {
        abort(404, 'Restaurant not found');
    }

    return view('restaurants.detail', compact('restaurant'));
    }
}
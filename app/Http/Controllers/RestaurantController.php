<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    // Menampilkan semua restoran
    public function index(Request $request)
    {
        $search = $request->input('search');

        $restaurants = \App\Models\Restaurant::with('admin')
            ->when($search, function ($query, $search) {
                $query->whereHas('admin', function ($q) use ($search) {
                    $q->where('Restaurant_Name', 'ilike', "%{$search}%");
                })
                ->orWhere('food_name', 'ilike', "%{$search}%");
            })
            ->get();

        return view('restaurants.index', compact('restaurants'));
    }

    public function show($id)
    {
        try {
            // Ambil data restoran dari database lokal
            $restaurant = Restaurant::with('admin')->find($id);

            // Jika tidak ditemukan di database lokal, coba ambil dari Supabase
            if (!$restaurant) {
                Log::info('Restaurant not found in local DB, trying Supabase', ['id' => $id]);
                $response = Http::withHeaders([
                    'apikey' => env('SUPABASE_KEY'),
                    'Authorization' => 'Bearer ' . env('SUPABASE_KEY')
                ])->get(env('SUPABASE_URL') . '/rest/v1/restaurants', [
                    'id' => 'eq.' . $id,
                    'select' => '*'
                ]);
                $restaurant = $response->json()[0] ?? null;
            }

            if (!$restaurant) {
                abort(404, 'Restaurant not found');
            }

            // Ambil semua komentar
            
            // Ambil data admin (hanya jika data restoran ditemukan)
            $admin = null;
            if (is_object($restaurant) && isset($restaurant->admin_id)) {
                $admin = \App\Models\Admin::find($restaurant->admin_id);
            } elseif (is_array($restaurant) && isset($restaurant['admin_id'])) {
                $admin = \App\Models\Admin::find($restaurant['admin_id']);
            } elseif (isset($restaurant->admin)) {
                $admin = $restaurant->admin;
            }
            
            $coments = \App\Models\Coment::orderBy('id', 'desc')->get();
            return view('restaurants.detail', compact('restaurant', 'admin', 'coments'));
        } catch (\Exception $e) {
            Log::error('Error fetching restaurant', ['error' => $e->getMessage()]);
            abort(500, 'Server error while fetching restaurant details');
        }
    }

    /**
     * Menampilkan form untuk melakukan klaim diskon
     */
    public function showClaimForm($id)
    {
        try {
            // Coba ambil dari database lokal dulu
            $restaurant = Restaurant::find($id);
            
            // Jika tidak ditemukan di database lokal, coba ambil dari Supabase
            if (!$restaurant) {
                $response = Http::withHeaders([
                    'apikey' => env('SUPABASE_KEY'),
                    'Authorization' => 'Bearer ' . env('SUPABASE_KEY')
                ])->get(env('SUPABASE_URL') . '/rest/v1/restaurants', [
                    'id' => 'eq.' . $id,
                    'select' => '*'
                ]);
                
                if ($response->successful() && count($response->json()) > 0) {
                    $restaurant = (object) $response->json()[0];
                }
            }
            
            if (!$restaurant) {
                abort(404, 'Restaurant not found');
            }
            
            return view('restaurants.claim-form', compact('restaurant'));
        } catch (\Exception $e) {
            Log::error('Error in showClaimForm: ' . $e->getMessage());
            abort(500, 'Server error');
        }
    }

    /**
     * Proses pengiriman form klaim diskon
     */
    public function submitClaimForm(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);
        
        try {
            // Di sini Anda bisa menyimpan data claim ke database
            // atau mengirim email konfirmasi, dll.
            
            // Redirect ke halaman konfirmasi dengan pesan sukses
            return redirect()->route('frontend.restaurants.index')
                ->with('success', 'Permintaan klaim diskon berhasil! Silakan tunggu konfirmasi dari restoran.');
        } catch (\Exception $e) {
            Log::error('Error in submitClaimForm: ' . $e->getMessage());
            return back()->withInput()->withErrors(['general' => 'Terjadi kesalahan. Silakan coba lagi nanti.']);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Restaurant;
use App\Models\Article;

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

        $articles = Article::orderBy('uploaded_at', 'desc')->take(3)->get(); // Ambil 3 artikel terbaru

        return view('restaurants.index', compact('restaurants', 'articles'));
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
            // Dapatkan informasi restaurant
            $restaurant = Restaurant::find($id);
            if (!$restaurant) {
                Log::info('Trying to save claim to Supabase', [
                    'supabase_url' => env('SUPABASE_URL'),
                    'key_length' => strlen(env('SUPABASE_KEY')),
                    'restaurant_id' => $id,
                    'data' => [
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone']
                    ]
                ]);
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
                return back()->withErrors(['general' => 'Restaurant tidak ditemukan.']);
            }
            
            // Generate unique claim code
            $claimCode = 'RF-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Set expire time (24 hours from now)
            $expireAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Simpan data ke Supabase
            $response = Http::withHeaders([
                'apikey' => env('SUPABASE_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_KEY'),
                'Content-Type' => 'application/json',
                'Prefer' => 'return=minimal'
            ])
            ->withOptions([
                'verify' => false
            ])
            ->post(env('SUPABASE_URL') . '/rest/v1/discount_claims', [
                'restaurant_id' => (string)$id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'notes' => $validated['notes'] ?? '',
                'status' => 'pending',
                'claim_code' => $claimCode,
                'expire_at' => $expireAt
                // Biarkan created_at dan updated_at dihasilkan oleh default di Supabase
            ]);

            if (!$response->successful()) {
                Log::error('Error saving claim to Supabase', [
                    'error' => $response->body(),
                    'status' => $response->status(),
                    'request_data' => [
                        'restaurant_id' => $id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'notes' => $validated['notes'] ?? '',
                        'status' => 'pending',
                        'claim_code' => $claimCode
                    ]
                ]);
                return back()->withInput()->withErrors(['general' => 'Gagal menyimpan data klaim ke database. Error: ' . $response->body()]);
            }
                        
            // Redirect ke halaman konfirmasi dengan pesan sukses
            return redirect()->route('frontend.restaurants.index')
                ->with('success', 'Permintaan klaim diskon berhasil! Kode klaim Anda: ' . $claimCode);
        }catch (\Exception $e) {
            Log::error('Error in submitClaimForm: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'exception_class' => get_class($e)
            ]);
            
            // Tampilkan error untuk debugging (hapus/komentar untuk production)
            return back()->withInput()->withErrors([
                'general' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
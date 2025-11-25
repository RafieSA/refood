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
        $category = $request->input('category');
        $minDiscount = $request->input('discount');

        $restaurants = \App\Models\Restaurant::with('admin')
            ->when($category, function ($query, $category) {
                $query->where('food_type', $category);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('admin', function ($q) use ($search) {
                    $q->where('Restaurant_Name', 'ilike', "%{$search}%");
                })
                ->orWhere('food_name', 'ilike', "%{$search}%");
            })
            ->when($minDiscount, function ($query, $minDiscount) {
                $query->where('discount_percentage', '>=', $minDiscount);
            })
            ->get();

        $articles = Article::orderBy('uploaded_at', 'desc')->take(3)->get();
        
        // Ambil categories dari database (distinct food_type)
        $categories = \App\Models\Restaurant::select('food_type')
            ->distinct()
            ->whereNotNull('food_type')
            ->orderBy('food_type')
            ->pluck('food_type');

        return view('restaurants.index', compact('restaurants', 'articles', 'category', 'categories'));
    }

    public function show($id, Request $request)
    {
        try {
            // Ambil data restoran dari database lokal
            $restaurant = Restaurant::with('admin')->find($id);

            // Jika tidak ditemukan di database lokal, coba ambil dari Supabase
            if (!$restaurant) {
                Log::info('Restaurant not found in local DB, trying Supabase', ['id' => $id]);
                $supabaseUrl = config('services.supabase.url');
                $supabaseKey = config('services.supabase.key');
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey
                ])->get($supabaseUrl . '/rest/v1/restaurants', [
                    'id' => 'eq.' . $id,
                    'select' => '*'
                ]);
                $restaurant = $response->json()[0] ?? null;
            }

            if (!$restaurant) {
                abort(404, 'Restaurant not found');
            }

            // Ambil data admin (hanya jika data restoran ditemukan)
            $admin = null;
            if (is_object($restaurant) && isset($restaurant->admin_id)) {
                $admin = \App\Models\Admin::find($restaurant->admin_id);
            } elseif (is_array($restaurant) && isset($restaurant['admin_id'])) {
                $admin = \App\Models\Admin::find($restaurant['admin_id']);
            } elseif (isset($restaurant->admin)) {
                $admin = $restaurant->admin;
            }
            
            // Get sort parameter (default: newest)
            $sort = $request->input('sort', 'newest');
            
            // Ambil comments HANYA untuk restaurant ini dengan pagination dan sorting
            $query = \App\Models\Coment::where('restaurant_id', $id);
            
            switch ($sort) {
                case 'highest':
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'lowest':
                    $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
            
            $coments = $query->paginate(10)->appends(['sort' => $sort]);
            
            // Hitung average rating dan total reviews dari semua comments (tidak hanya halaman saat ini)
            $totalReviews = \App\Models\Coment::where('restaurant_id', $id)->count();
            $averageRating = \App\Models\Coment::where('restaurant_id', $id)->avg('rating') ?? 0;
            
            return view('restaurants.detail', compact('restaurant', 'admin', 'coments', 'averageRating', 'totalReviews', 'sort'));
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
                $supabaseUrl = config('services.supabase.url');
                $supabaseKey = config('services.supabase.key');
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey
                ])->get($supabaseUrl . '/rest/v1/restaurants', [
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
            // Get Supabase config
            $supabaseUrl = config('services.supabase.url');
            $supabaseKey = config('services.supabase.key');
            
            // Dapatkan informasi restaurant
            $restaurant = Restaurant::find($id);
            if (!$restaurant) {
                Log::info('Trying to save claim to Supabase', [
                    'supabase_url' => $supabaseUrl,
                    'key_length' => strlen($supabaseKey ?? ''),
                    'restaurant_id' => $id,
                    'data' => [
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone']
                    ]
                ]);
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey
                ])->get($supabaseUrl . '/rest/v1/restaurants', [
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
                'apikey' => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=minimal'
            ])
            ->withOptions([
                'verify' => false
            ])
            ->post($supabaseUrl . '/rest/v1/discount_claims', [
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
            return redirect()->route('frontend.home')
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

    public function about($id)
    {
        try {
            // Ambil data restoran dari database lokal
            $restaurant = Restaurant::with('admin')->find($id);

            // Jika tidak ditemukan di database lokal, coba ambil dari Supabase
            if (!$restaurant) {
                $supabaseUrl = config('services.supabase.url');
                $supabaseKey = config('services.supabase.key');
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey
                ])->get($supabaseUrl . '/rest/v1/restaurants', [
                    'id' => 'eq.' . $id,
                    'select' => '*'
                ]);
                $restaurant = $response->json()[0] ?? null;
            }

            if (!$restaurant) {
                abort(404, 'Restaurant not found');
            }

            // Ambil data admin
            $admin = null;
            if (is_object($restaurant) && isset($restaurant->admin_id)) {
                $admin = \App\Models\Admin::find($restaurant->admin_id);
            } elseif (is_array($restaurant) && isset($restaurant['admin_id'])) {
                $admin = \App\Models\Admin::find($restaurant['admin_id']);
            } elseif (isset($restaurant->admin)) {
                $admin = $restaurant->admin;
            }
            
            return view('restaurants.about', compact('restaurant', 'admin'));
        } catch (\Exception $e) {
            Log::error('Error fetching restaurant for about page', ['error' => $e->getMessage()]);
            abort(500, 'Server error while fetching restaurant details');
        }
    }
}
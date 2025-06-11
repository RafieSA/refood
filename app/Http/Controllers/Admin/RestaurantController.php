<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'admin_id',
        'name',
        'address',
        'food_name',
        'food_type',
        'discount_percentage',
        'discount_duration_hours',
        'discount',
        'photo_url',
        'opening_hours',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relationship with Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $restaurants = \App\Models\Restaurant::with('admin')
            ->when($category, function ($query, $category) {
                $query->where('food_type', 'ilike', $category);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('admin', function ($q) use ($search) {
                    $q->where('Restaurant_Name', 'ilike', "%{$search}%");
                })
                ->orWhere('food_name', 'ilike', "%{$search}%");
            })
            ->get();

        $articles = Article::orderBy('uploaded_at', 'desc')->take(3)->get();

        return view('restaurants.index', compact('restaurants', 'articles', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'food_name' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'discount_duration_hours' => 'required|numeric|min:1',
            'opening_hours' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $restaurant = new Restaurant();
        $restaurant->fill($validated);
        $restaurant->admin_id = auth()->guard('admins')->id();

        if ($request->hasFile('photo')) {
            // Simpan file ke direktori public/restaurants
            $path = $request->file('photo')->storeAs('restaurants', $request->file('photo')->getClientOriginalName(), 'public');
            $restaurant->photo_url = '/storage/' . $path; // URL yang dapat diakses
        }

        $restaurant->save();

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        return view('admin.restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'food_name' => 'required|string|max:255',
            'food_type' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'discount' => 'required|numeric|min:0',
            'discount_duration_hours' => 'required|numeric|min:1',
            'opening_hours' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $restaurant->fill($validated);

        if ($request->hasFile('photo')) {
            if ($restaurant->photo_url && Storage::exists('public/' . str_replace('/storage/', '', $restaurant->photo_url))) {
                Storage::delete('public/' . str_replace('/storage/', '', $restaurant->photo_url));
            }

            $path = $request->file('photo')->storeAs('restaurants', $request->file('photo')->getClientOriginalName(), 'public');
            $restaurant->photo_url = '/storage/' . $path;
        }

        $restaurant->save();

        // Jika super-admin, redirect ke dashboard super-admin
        if (auth()->guard('super_admins')->check()) {
            return redirect()->route('super_admin.dashboard')->with('success', 'Restaurant updated successfully');
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->photo_url && Storage::exists('public/' . str_replace('/storage/', '', $restaurant->photo_url))) {
            Storage::delete('public/' . str_replace('/storage/', '', $restaurant->photo_url));
        }

        $restaurant->delete();

        // Jika super-admin, redirect ke dashboard super-admin
        if (auth()->guard('super_admins')->check()) {
            return redirect()->route('super_admin.dashboard')->with('success', 'Restaurant deleted successfully');
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant deleted successfully');
    }
}
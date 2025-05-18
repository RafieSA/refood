<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.super_admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.super_admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Restaurant_Name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
            'Restaurant_Photo' => 'nullable|image|max:2048',
        ]);

        $admin = new Admin();
        $admin->Restaurant_Name = $validated['Restaurant_Name'];
        $admin->email = $validated['email'];
        $admin->password = bcrypt($validated['password']);

        if ($request->hasFile('Restaurant_Photo')) {
            $path = $request->file('Restaurant_Photo')->store('admins', 'public');
            $admin->Restaurant_Photo = $path;
        }

        $admin->save();

        // Ambil data untuk dashboard
        $admins = Admin::all();
        $restaurants = \App\Models\Restaurant::with('admin')->get();

        return view('admin.super_admins.dashboard', compact('admins', 'restaurants'))->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.super_admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'Restaurant_Name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8',
            'Restaurant_Photo' => 'nullable|image|max:2048',
        ]);

        $admin->Restaurant_Name = $validated['Restaurant_Name'];
        $admin->email = $validated['email'];

        if ($request->filled('password')) {
            $admin->password = bcrypt($validated['password']);
        }

        if ($request->hasFile('Restaurant_Photo')) {
            $path = $request->file('Restaurant_Photo')->store('admins', 'public');
            $admin->Restaurant_Photo = $path;
        }

        $admin->save();

        $admins = Admin::all();
        $restaurants = \App\Models\Restaurant::with('admin')->get();

        return view('admin.super_admins.dashboard', compact('admins', 'restaurants'))->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        $admins = Admin::all();
        $restaurants = \App\Models\Restaurant::with('admin')->get();

        return view('admin.super_admins.dashboard', compact('admins', 'restaurants'))->with('success', 'Admin deleted successfully.');
    }
}

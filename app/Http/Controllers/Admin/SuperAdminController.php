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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        Admin::create($validated);

        return redirect()->route('super_admins.index')->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.super_admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('super_admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.super_admins.index')->with('success', 'Admin deleted successfully.');
    }
}

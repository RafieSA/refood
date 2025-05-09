<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admins')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        $validated = $request->validate([
            'Restaurant_Name' => 'required|string|max:255',
            'Restaurant_Photo' => 'nullable|image|max:2048',
        ]);

        $admin->Restaurant_Name = $validated['Restaurant_Name'];

        if ($request->hasFile('Restaurant_Photo')) {
            // Hapus foto lama jika ada
            if ($admin->Restaurant_Photo && Storage::exists('public/' . $admin->Restaurant_Photo)) {
                Storage::delete('public/' . $admin->Restaurant_Photo);
            }

            // Simpan foto baru
            $path = $request->file('Restaurant_Photo')->store('admins', 'public');
            $admin->Restaurant_Photo = $path;
        }

        $admin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }
}

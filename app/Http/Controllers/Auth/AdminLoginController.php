<?php
// filepath: d:\Kuliah\Semester 6\ppl-refood\SI4605-KEL411\app\Http\Controllers\Auth\AdminLoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Log or dump request data for debugging
        \Log::info($request->all());

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate using the 'admins' guard
        if (Auth::guard('admins')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not an admin.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admins')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
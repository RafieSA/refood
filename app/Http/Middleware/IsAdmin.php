<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is authenticated using the 'admins' guard
        if (!Auth::guard('admins')->check()) {
            // If request expects JSON, return JSON response
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // For web requests, redirect to admin login
            return redirect()->guest(route('admin.login'))->with('error', 'Please login to access the admin dashboard.');
        }

        return $next($request);
    }
}

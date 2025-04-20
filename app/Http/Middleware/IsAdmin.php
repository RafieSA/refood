<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }
    
        // Redirect ke login admin jika bukan admin atau belum login
        return redirect()->route('admin.login')->with('error', 'Access denied. Please login as admin.');
    }
}
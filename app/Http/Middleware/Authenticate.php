<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Log URL yang diminta untuk debugging
            \Log::info('URL requested:', ['url' => $request->path()]);
            
            // Redirect ke login admin hanya jika rute mengarah ke admin
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Biarkan akses tanpa login untuk semua URL yang dimulai dengan 'restaurants'
            if (str_starts_with($request->path(), 'restaurants')) {
                return null;
            }

            // Jika tidak, arahkan ke rute login default
            return route('login');
        }
    }
}
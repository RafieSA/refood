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
            // Redirect ke login admin jika rute mengarah ke admin
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Jika tidak, arahkan ke rute login default (jika ada)
            return route('login');
        }
    }
}
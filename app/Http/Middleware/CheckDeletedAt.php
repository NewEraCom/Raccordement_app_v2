<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDeletedAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and the deleted_at column is not null
        if (Auth::check() && Auth::user()->deleted_at !== null) {
            // Redirect to login page
            Auth::logout();
            return redirect('/');
        }

        return $next($request);
    }
}

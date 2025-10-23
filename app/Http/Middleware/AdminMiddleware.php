<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        return $next($request);
    }
}

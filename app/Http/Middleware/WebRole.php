<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class WebRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check() && in_array(Auth::user()->role_id, $roles)) {
            return $next($request);
        }

        return response(view('unauthorized')); // Buat view unauthorized.blade.php di resources/views
    }
}

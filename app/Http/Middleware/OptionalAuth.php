<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OptionalAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika route adalah karya.show dan user belum login
        if ($request->route()->getName() === 'karya.show' && !Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Login untuk melihat detail karya');
        }

        return $next($request);
    }
}

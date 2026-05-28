<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            return $next($request);
        }

        // Store the intended URL for redirect after login
        session()->put('url.intended', $request->url());

        return redirect('login')->withErrors('Silakan Login Terlebih Dahulu');
    }
}

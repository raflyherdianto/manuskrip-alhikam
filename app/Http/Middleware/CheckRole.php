<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            // Redirect ke halaman login sesuai dengan role yang diminta
            if ($role === 'superadmin') {
                return redirect()->route('superadmin.login')->withErrors('Silakan login sebagai superadmin terlebih dahulu');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.login')->withErrors('Silakan login sebagai admin terlebih dahulu');
            }
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu');
        }

        if (Auth::user()->role !== $role) {
            Auth::logout();

            // Redirect ke halaman login yang sesuai jika role tidak cocok
            if ($role === 'superadmin') {
                return redirect()->route('superadmin.login')->withErrors('Anda tidak memiliki akses sebagai superadmin');
            } elseif ($role === 'admin') {
                return redirect()->route('admin.login')->withErrors('Anda tidak memiliki akses sebagai admin');
            }

            return redirect()->route('login')->withErrors('Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}

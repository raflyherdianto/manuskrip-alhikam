<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // For file download routes, store the referer (karya detail page) as intended URL
        if ($request->is('files/*')) {
            $referer = $request->headers->get('referer');
            if ($referer) {
                session()->put('url.intended', $referer);
            }
        } else {
            // Store the current URL for redirect after login
            session()->put('url.intended', $request->url());
        }

        return route('login');
    }
}

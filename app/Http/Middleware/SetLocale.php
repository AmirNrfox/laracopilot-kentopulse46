<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Read locale from session, default to 'fa'
        $locale = session('locale', 'fa');

        // Validate (defensive)
        if (!in_array($locale, ['fa', 'en'])) {
            $locale = 'fa';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
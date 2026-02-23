<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        // Only allow supported locales
        if (!in_array($locale, ['fa', 'en'])) {
            $locale = 'fa';
        }

        // Store in session (SetLocale middleware reads from here)
        session(['locale' => $locale]);

        // Redirect back (or home if no referrer)
        return redirect()->back()->withHeaders([
            // prevent caching so locale change is immediate
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }
}
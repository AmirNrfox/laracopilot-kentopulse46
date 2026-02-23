<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Rate limiting: max 5 attempts per minute per IP
        $key = 'admin-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many login attempts. Please wait {$seconds} seconds."
            ]);
        }

        $user = User::where('email', $request->email)
            ->where('role', 'admin')
            ->where('active', true)
            ->first();

        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            session([
                'admin_logged_in' => true,
                'admin_user'      => $user->name,
                'admin_email'     => $user->email,
                'admin_id'        => $user->id,
            ]);
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key, 60);
        return back()->withErrors(['email' => 'ایمیل یا رمز عبور اشتباه است'])->withInput();
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email', 'admin_id']);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
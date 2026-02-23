<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => app()->getLocale() === 'fa' ? 'ایمیل الزامی است' : 'Email is required',
            'email.email'       => app()->getLocale() === 'fa' ? 'ایمیل معتبر وارد کنید' : 'Enter a valid email',
            'password.required' => app()->getLocale() === 'fa' ? 'رمز عبور الزامی است' : 'Password is required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => true], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => app()->getLocale() === 'fa' ? 'ایمیل یا رمز عبور اشتباه است' : 'Invalid email or password',
        ])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $fa = app()->getLocale() === 'fa';
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'nullable|string|max:20',
        ], [
            'name.required'      => $fa ? 'نام الزامی است' : 'Name is required',
            'email.required'     => $fa ? 'ایمیل الزامی است' : 'Email is required',
            'email.unique'       => $fa ? 'این ایمیل قبلاً ثبت شده' : 'This email is already registered',
            'password.min'       => $fa ? 'رمز عبور حداقل ۶ کاراکتر باشد' : 'Password must be at least 6 characters',
            'password.confirmed' => $fa ? 'تکرار رمز عبور مطابقت ندارد' : 'Password confirmation does not match',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', $fa ? 'خوش آمدید! ثبت نام با موفقیت انجام شد.' : 'Welcome! Registration successful.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function profile()
    {
        if (!Auth::check()) return redirect()->route('login');
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');
        $fa   = app()->getLocale() === 'fa';
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required'      => $fa ? 'نام الزامی است' : 'Name is required',
            'password.confirmed' => $fa ? 'تکرار رمز عبور مطابقت ندارد' : 'Password confirmation mismatch',
        ]);

        $user->name  = $request->name;
        $user->phone = $request->phone;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', $fa ? '✅ پروفایل با موفقیت بروزرسانی شد' : '✅ Profile updated successfully');
    }
}
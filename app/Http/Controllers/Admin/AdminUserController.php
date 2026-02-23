<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $query = User::where('role', 'user')->withCount('orders');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }
        $users = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        if ($r = $this->checkAuth()) return $r;
        // Eager load orders to avoid N+1 in the view
        $user = User::with(['orders' => function ($q) {
            $q->orderBy('created_at', 'desc')->take(20);
        }])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->checkAuth()) return $r;
        $user = User::findOrFail($id);
        $user->update(['active' => (bool) $request->input('active', 1)]);
        return back()->with('success', $user->active ? 'کاربر فعال شد ✅' : 'کاربر مسدود شد 🔒');
    }
}
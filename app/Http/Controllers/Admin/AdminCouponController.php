<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'       => 'required|string|max:50|unique:coupons',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|integer|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);
        $data['active'] = $request->has('active');
        $data['code']   = strtoupper($data['code']);
        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'کوپن ایجاد شد ✅');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $data = $request->validate([
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|integer|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);
        $data['active'] = $request->has('active');
        $coupon->update($data);
        return redirect()->route('admin.coupons.index')->with('success', 'کوپن ویرایش شد ✅');
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'کوپن حذف شد');
    }
}

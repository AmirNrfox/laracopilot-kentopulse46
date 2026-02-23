<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->checkAuth()) return $r;
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if ($r = $this->checkAuth()) return $r;

        $textFields = [
            'site_name_fa', 'site_name_en', 'site_email', 'site_phone',
            'site_address_fa', 'site_address_en',
            'instagram', 'telegram', 'twitter', 'youtube',
            'whatsapp_number', 'whatsapp_message_fa', 'whatsapp_message_en',
            'zarinpal_merchant_id',
            'shipping_cost', 'free_shipping_min',
            'seo_title_fa', 'seo_title_en',
            'seo_description_fa', 'seo_description_en',
            'seo_keywords',
            'google_analytics_id', 'google_verification',
        ];

        foreach ($textFields as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->get($key));
            }
        }

        // Boolean toggles
        Setting::set('payment_enabled', $request->has('payment_enabled') ? '1' : '0');
        Setting::set('zarinpal_sandbox', $request->has('zarinpal_sandbox') ? '1' : '0');

        return back()->with('success', 'تنظیمات با موفقیت ذخیره شد ✅');
    }
}
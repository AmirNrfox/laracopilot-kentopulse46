@extends('layouts.admin')
@section('title', 'تنظیمات پیشرفته')
@section('page-title', 'تنظیمات پیشرفته سایت')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" x-data="{ tab: 'general' }">
@csrf

{{-- Tabs --}}
<div class="bg-white rounded-2xl shadow mb-6">
    <div class="flex overflow-x-auto border-b">
        @foreach([
            ['key'=>'general','icon'=>'🏪','label'=>'اطلاعات عمومی'],
            ['key'=>'payment','icon'=>'💳','label'=>'پرداخت'],
            ['key'=>'whatsapp','icon'=>'💬','label'=>'واتس‌اپ'],
            ['key'=>'seo','icon'=>'🔍','label'=>'SEO'],
            ['key'=>'social','icon'=>'📱','label'=>'شبکه اجتماعی'],
            ['key'=>'shipping','icon'=>'🚚','label'=>'ارسال'],
        ] as $t)
        <button type="button" @click="tab='{{ $t['key'] }}'" :class="tab==='{{ $t['key'] }}' ? 'border-b-2 border-green-600 text-green-700 font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-4 text-sm whitespace-nowrap flex items-center gap-2 transition-colors">{{ $t['icon'] }} {{ $t['label'] }}</button>
        @endforeach
    </div>

    <div class="p-6">
        {{-- General --}}
        <div x-show="tab==='general'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام فروشگاه (فارسی) *</label>
                    <input type="text" name="site_name_fa" value="{{ $settings['site_name_fa'] ?? '' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Name (English) *</label>
                    <input type="text" name="site_name_en" value="{{ $settings['site_name_en'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ایمیل سایت</label>
                    <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">شماره تلفن</label>
                    <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">آدرس (فارسی)</label>
                    <input type="text" name="site_address_fa" value="{{ $settings['site_address_fa'] ?? '' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address (English)</label>
                    <input type="text" name="site_address_en" value="{{ $settings['site_address_en'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>
        </div>

        {{-- Payment --}}
        <div x-show="tab==='payment'" class="space-y-5">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-black text-gray-900 text-lg">🔌 درگاه پرداخت آنلاین (زرین‌پال)</h4>
                        <p class="text-sm text-gray-600 mt-1">وقتی غیرفعال است: دکمه پرداخت پنهان، دکمه بزرگ واتس‌اپ نمایش داده می‌شود</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="payment_enabled" value="1" {{ ($settings['payment_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-16 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:{{ app()->getLocale() === 'fa' ? 'right-1' : 'left-1' }} after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-600"></div>
                    </label>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">کد مرچنت زرین‌پال (Merchant ID)</label>
                    <input type="text" name="zarinpal_merchant_id" value="{{ $settings['zarinpal_merchant_id'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono text-sm" placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX">
                    <p class="text-xs text-gray-400 mt-1">از پنل زرین‌پال خود بگیرید: <a href="https://www.zarinpal.com" target="_blank" class="text-green-600 hover:underline">zarinpal.com</a></p>
                </div>
                <label class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 cursor-pointer">
                    <input type="checkbox" name="zarinpal_sandbox" value="1" {{ ($settings['zarinpal_sandbox'] ?? '1') == '1' ? 'checked' : '' }} class="w-5 h-5 rounded accent-blue-600">
                    <div>
                        <span class="font-bold text-blue-800">🧪 حالت Sandbox (آزمایشی)</span>
                        <p class="text-xs text-blue-600">قبل از راه‌اندازی واقعی فعال باشد. برای محیط production غیرفعال کنید.</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- WhatsApp --}}
        <div x-show="tab==='whatsapp'" class="space-y-4">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800">
                💡 لینک واتس‌اپ به صورت خودکار ساخته می‌شود: <code class="bg-green-100 px-2 py-0.5 rounded font-mono">https://wa.me/{شماره}?text={پیام}</code>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">شماره واتس‌اپ (با کد کشور، بدون + و فاصله)</label>
                <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="989123456789">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">پیام پیش‌فرض (فارسی)</label>
                <textarea name="whatsapp_message_fa" rows="3" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ $settings['whatsapp_message_fa'] ?? 'سلام، می‌خواهم درباره محصولات شما مشاوره بگیرم' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Default Message (English)</label>
                <textarea name="whatsapp_message_en" rows="3" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ $settings['whatsapp_message_en'] ?? 'Hello, I want to consult about your products' }}</textarea>
            </div>
        </div>

        {{-- SEO --}}
        <div x-show="tab==='seo'" class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800">
                🔍 این اطلاعات در متاتگ‌های سایت و نتایج گوگل نمایش داده می‌شوند.
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">عنوان پیش‌فرض صفحه اصلی (فارسی)</label>
                <input type="text" name="seo_title_fa" value="{{ $settings['seo_title_fa'] ?? '' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="فروشگاه مکمل ورزشی | خرید مکمل اصل">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Default Page Title (English)</label>
                <input type="text" name="seo_title_en" value="{{ $settings['seo_title_en'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Sports Supplement Store | Buy Original Supplements">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">توضیح متا (فارسی) - حداکثر ۱۶۰ کاراکتر</label>
                <textarea name="seo_description_fa" rows="3" maxlength="160" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ $settings['seo_description_fa'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description (English) - Max 160 chars</label>
                <textarea name="seo_description_en" rows="3" maxlength="160" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ $settings['seo_description_en'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">کلمات کلیدی (جدا با کاما)</label>
                <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? '' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="مکمل ورزشی, پروتئین, کراتین, خرید مکمل">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics ID</label>
                <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono" placeholder="G-XXXXXXXXXX">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Google Search Console Verification</label>
                <input type="text" name="google_verification" value="{{ $settings['google_verification'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono" placeholder="google-site-verification=...">
            </div>
        </div>

        {{-- Social --}}
        <div x-show="tab==='social'" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🌐 آدرس اینستاگرام</label>
                <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="https://instagram.com/yourpage">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">✈️ آدرس تلگرام</label>
                <input type="url" name="telegram" value="{{ $settings['telegram'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="https://t.me/yourchannel">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🐦 آدرس توییتر/X</label>
                <input type="url" name="twitter" value="{{ $settings['twitter'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="https://twitter.com/yourhandle">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">▶️ آدرس یوتیوب</label>
                <input type="url" name="youtube" value="{{ $settings['youtube'] ?? '' }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="https://youtube.com/@yourchannel">
            </div>
        </div>

        {{-- Shipping --}}
        <div x-show="tab==='shipping'" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">هزینه ارسال (تومان)</label>
                    <input type="number" name="shipping_cost" value="{{ $settings['shipping_cost'] ?? '50000' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">حداقل خرید برای ارسال رایگان (تومان)</label>
                    <input type="number" name="free_shipping_min" value="{{ $settings['free_shipping_min'] ?? '1000000' }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800">
                💡 اگر مبلغ خرید بیشتر از حداقل باشد، هزینه ارسال صفر (رایگان) محاسبه می‌شود.
            </div>
        </div>
    </div>
</div>

{{-- Save Button --}}
<div class="flex items-center gap-4">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-black py-3.5 px-10 rounded-xl transition-colors text-lg shadow-lg shadow-green-500/30">
        💾 ذخیره تمام تنظیمات
    </button>
    <span class="text-gray-400 text-sm">آخرین ذخیره: {{ now()->format('Y/m/d H:i') }}</span>
</div>

</form>

@section('scripts')
<script>
// Auto-save indicator
document.querySelectorAll('input, textarea, select').forEach(el => {
    el.addEventListener('change', () => {
        const indicator = document.createElement('span');
        indicator.className = 'fixed bottom-4 right-4 bg-yellow-400 text-gray-900 px-4 py-2 rounded-xl text-sm font-bold shadow-lg z-50';
        indicator.textContent = '⚠️ تغییرات ذخیره نشده';
        indicator.id = 'save-indicator';
        document.getElementById('save-indicator')?.remove();
        document.body.appendChild(indicator);
    });
});
document.querySelector('form').addEventListener('submit', () => {
    document.getElementById('save-indicator')?.remove();
});
</script>
@endsection
@endsection

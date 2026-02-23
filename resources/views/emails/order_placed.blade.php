<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    {{-- All email styles live in public/css/custom.css under .email-* classes --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="email-wrap">
<div class="email-container">
    <div class="email-header">
        <div style="font-size:48px">💪</div>
        {{-- ☝️ font-size: 48px is a one-off emoji size — kept inline intentionally --}}
        <h1>سفارش شما ثبت شد!</h1>
        <p style="color:#bbf7d0;margin:5px 0 0">{{ $order->order_number }}</p>
    </div>
    <div class="email-body">
        <p>سلام {{ $order->first_name }} {{ $order->last_name }} عزیز،</p>
        <p>سفارش شما با موفقیت ثبت شد و در حال پردازش است.</p>

        <div class="email-info-box">
            <div class="email-row">
                <span style="color:#6b7280">شماره سفارش:</span>
                <span style="font-family:monospace;font-weight:bold;color:#16a34a">{{ $order->order_number }}</span>
            </div>
            <div class="email-row">
                <span style="color:#6b7280">روش پرداخت:</span>
                <span>{{ $order->payment_method === 'whatsapp' ? '💬 واتس‌اپ' : '💳 زرین‌پال' }}</span>
            </div>
            <div class="email-row">
                <span style="color:#6b7280">وضعیت:</span>
                <span class="email-badge">{{ $order->status_label }}</span>
            </div>
        </div>

        <h3 style="margin-top:24px">اقلام سفارش:</h3>
        @foreach($order->items as $item)
        <div class="email-row">
            <span>{{ $item->product_name }}{{ $item->variant_info ? ' - '.$item->variant_info : '' }} × {{ $item->quantity }}</span>
            <span>{{ number_format($item->total) }} ت</span>
        </div>
        @endforeach
        @if($order->discount > 0)
        <div class="email-row" style="color:#dc2626">
            <span>تخفیف:</span><span>-{{ number_format($order->discount) }}</span>
        </div>
        @endif
        <div class="email-row"><span>ارسال:</span><span>{{ $order->shipping > 0 ? number_format($order->shipping) : 'رایگان' }}</span></div>
        <div class="email-row email-row-total"><span>جمع کل:</span><span>{{ number_format($order->total) }} تومان</span></div>

        <div class="email-address-box">
            <strong>📍 آدرس تحویل:</strong><br>
            {{ $order->address }}، {{ $order->city }}، {{ $order->province }}<br>
            کد پستی: {{ $order->postal_code }}
        </div>

        <div style="text-align:center">
            <a href="{{ route('orders.my') }}" class="email-btn">📦 پیگیری سفارش</a>
        </div>
    </div>
    <div class="email-footer">
        <p>این ایمیل به صورت خودکار ارسال شده است. پاسخ ندهید.</p>
        <p>Made with ❤️ by <a href="https://laracopilot.com" style="color:#16a34a">LaraCopilot</a></p>
    </div>
</div>
</body>
</html>

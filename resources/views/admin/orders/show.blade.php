@extends('layouts.admin')
@section('title', 'جزئیات سفارش')
@section('page-title', 'سفارش ' . $order->order_number)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        {{-- Items --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black mb-4">اقلام سفارش</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-start border-b pb-4 last:border-0 last:pb-0">
                    <div>
                        <div class="font-medium">{{ $item->product_name }}</div>
                        @if($item->variant_info)
                            <div class="text-xs text-gray-500 mt-0.5">{{ $item->variant_info }}</div>
                        @endif
                        <div class="text-sm text-gray-500 mt-1">× {{ $item->quantity }} × {{ number_format($item->price) }}</div>
                    </div>
                    <div class="font-black text-gray-900">{{ number_format($item->total) }}</div>
                </div>
                @endforeach
            </div>
            <div class="border-t mt-4 pt-4 space-y-2 text-sm">
                <div class="flex justify-between"><span>جمع اقلام:</span><span>{{ number_format($order->subtotal) }}</span></div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-red-600"><span>تخفیف:</span><span>-{{ number_format($order->discount) }}</span></div>
                @endif
                <div class="flex justify-between"><span>ارسال:</span><span>{{ $order->shipping > 0 ? number_format($order->shipping) : 'رایگان' }}</span></div>
                <div class="flex justify-between font-black text-lg border-t pt-2">
                    <span>جمع کل:</span>
                    <span class="text-green-700">{{ number_format($order->total) }} تومان</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black mb-4">آدرس تحویل</h3>
            <div class="text-sm text-gray-600 space-y-1">
                <div class="font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                <div>📞 {{ $order->phone }}</div>
                <div>📧 {{ $order->email }}</div>
                <div>📍 {{ $order->address }}</div>
                <div>{{ $order->city }}، {{ $order->province }} — {{ $order->postal_code }}</div>
                @if($order->notes)<div class="bg-yellow-50 rounded p-2 mt-2">📝 {{ $order->notes }}</div>@endif
            </div>
        </div>
    </div>

    {{-- Status & Actions --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black mb-4">وضعیت سفارش</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">پرداخت:</span>
                    <span class="font-bold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $order->payment_status === 'paid' ? '✅ پرداخت شده' : '⏳ در انتظار' }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">روش پرداخت:</span>
                    <span class="font-medium">{{ $order->payment_method === 'whatsapp' ? '💬 واتس‌اپ' : '💳 زرین‌پال' }}</span>
                </div>
                @if($order->transaction_id)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">کد پیگیری:</span>
                    <span class="font-mono text-xs">{{ $order->transaction_id }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black mb-4">تغییر وضعیت</h3>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf @method('PUT')
                <select name="status" class="w-full border-2 rounded-xl px-3 py-2.5 text-sm mb-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    @foreach(['pending'=>'در انتظار','processing'=>'در حال پردازش','shipped'=>'ارسال شده','delivered'=>'تحویل داده شده','cancelled'=>'لغو شده'] as $val => $label)
                    <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl">بروزرسانی</button>
            </form>
        </div>
    </div>
</div>
@endsection

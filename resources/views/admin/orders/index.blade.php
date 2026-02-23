@extends('layouts.admin')
@section('title','سفارشات')
@section('page-title','مدیریت سفارشات')
@section('content')
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو در سفارشات..." class="border-2 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none flex-1 min-w-48">
    <select name="status" class="border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
        <option value="">همه وضعیت‌ها</option>
        <option value="pending" {{ request('status')==='pending'?'selected':'' }}>در انتظار</option>
        <option value="processing" {{ request('status')==='processing'?'selected':'' }}>پردازش</option>
        <option value="shipped" {{ request('status')==='shipped'?'selected':'' }}>ارسال شده</option>
        <option value="delivered" {{ request('status')==='delivered'?'selected':'' }}>تحویل داده شده</option>
        <option value="cancelled" {{ request('status')==='cancelled'?'selected':'' }}>لغو شده</option>
    </select>
    <select name="payment_status" class="border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
        <option value="">وضعیت پرداخت</option>
        <option value="paid" {{ request('payment_status')==='paid'?'selected':'' }}>پرداخت شده</option>
        <option value="unpaid" {{ request('payment_status')==='unpaid'?'selected':'' }}>پرداخت نشده</option>
    </select>
    <button class="bg-green-600 text-white font-bold py-2 px-5 rounded-xl">🔍 جستجو</button>
    <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 text-gray-600 font-bold py-2 px-4 rounded-xl">پاک</a>
</form>
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">شماره سفارش</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">مشتری</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">مبلغ</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">پرداخت</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">وضعیت</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">تاریخ</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">جزئیات</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono font-bold text-green-700">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">
                        <div>{{ $order->first_name }} {{ $order->last_name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->phone }}</div>
                    </td>
                    <td class="px-4 py-3 font-semibold">{{ number_format($order->total) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $order->payment_status === 'paid' ? '✅ پرداخت شده' : '⏳ نپرداخته' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')) }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $order->created_at->format('Y/m/d') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline text-xs">مشاهده ←</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">سفارشی یافت نشد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection

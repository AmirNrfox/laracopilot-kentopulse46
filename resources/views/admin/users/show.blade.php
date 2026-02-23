@extends('layouts.admin')
@section('title', 'جزئیات کاربر')
@section('page-title', $user->name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-black text-3xl mx-auto mb-3">{{ mb_substr($user->name, 0, 1) }}</div>
            <h2 class="font-black text-xl">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">موبایل:</span><span>{{ $user->phone ?? '—' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">تعداد سفارش:</span><span class="font-bold text-green-700">{{ $user->orders->count() }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">عضویت:</span><span>{{ $user->created_at->format('Y/m/d') }}</span></div>
            <div class="flex justify-between">
                <span class="text-gray-500">وضعیت:</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $user->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->active ? 'فعال' : 'مسدود' }}</span>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow">
            <div class="px-6 py-4 border-b"><h3 class="font-black">سفارشات کاربر</h3></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50"><tr>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">شماره</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">مبلغ</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">وضعیت</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-600">تاریخ</th>
                    </tr></thead>
                    <tbody class="divide-y">
                        @forelse($user->orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono"><a href="{{ route('admin.orders.show', $order->id) }}" class="text-green-600 hover:underline">{{ $order->order_number }}</a></td>
                            <td class="px-4 py-3 font-semibold">{{ number_format($order->total) }}</td>
                            <td class="px-4 py-3">{{ $order->status_label }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $order->created_at->format('Y/m/d') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">سفارشی ندارد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

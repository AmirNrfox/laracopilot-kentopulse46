@extends('layouts.admin')
@section('title', 'داشبورد')
@section('page-title', 'داشبورد')

@section('content')

{{-- Livewire Stock Alert --}}
@livewire('admin-stock-alert')

{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl shadow p-6 border-b-4 border-green-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm font-medium">کل سفارشات</p>
                <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($totalOrders) }}</p>
                @if($pendingOrders)
                    <p class="text-orange-500 text-xs mt-1 font-medium">⏳ {{ $pendingOrders }} در انتظار</p>
                @endif
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">🛍️</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 border-b-4 border-blue-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm font-medium">درآمد کل</p>
                <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($totalRevenue) }}</p>
                <p class="text-blue-500 text-xs mt-1">تومان (پرداخت شده)</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">💰</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 border-b-4 border-purple-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm font-medium">کل محصولات</p>
                <p class="text-3xl font-black text-gray-900 mt-1">{{ $totalProducts }}</p>
                <p class="text-purple-500 text-xs mt-1">محصول در پایگاه داده</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl">📦</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 border-b-4 border-orange-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-400 text-sm font-medium">کاربران</p>
                <p class="text-3xl font-black text-gray-900 mt-1">{{ $totalUsers }}</p>
                @if($pendingReviews)
                    <p class="text-orange-500 text-xs mt-1">💬 {{ $pendingReviews }} نظر منتظر</p>
                @endif
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">👥</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Recent Orders --}}
    <div class="bg-white rounded-2xl shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-black text-gray-800">آخرین سفارشات</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-green-600 text-sm hover:underline font-medium">مشاهده همه ←</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">شماره سفارش</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">مشتری</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">مبلغ</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">وضعیت</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono"><a href="{{ route('admin.orders.show', $order->id) }}" class="text-green-600 hover:underline">{{ $order->order_number }}</a></td>
                        <td class="px-4 py-3">{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td class="px-4 py-3 font-semibold">{{ number_format($order->total) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-2xl shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="font-black text-gray-800">پرفروش‌ترین محصولات</h3>
            <a href="{{ route('admin.products.index') }}" class="text-green-600 text-sm hover:underline font-medium">مدیریت ←</a>
        </div>
        <div class="p-4 space-y-3">
            @foreach($topProducts as $i => $product)
            <div class="flex items-center gap-4">
                <div class="w-7 h-7 rounded-full flex items-center justify-center font-black text-sm
                    {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : ($i === 1 ? 'bg-gray-100 text-gray-600' : ($i === 2 ? 'bg-orange-100 text-orange-600' : 'bg-gray-50 text-gray-400')) }}">
                    {{ $i + 1 }}
                </div>
                <div class="w-12 h-12 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-contain p-1" onerror="this.src='data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"48\" height=\"48\"><rect fill=\"%23f3f4f6\" width=\"48\" height=\"48\"/></svg>'">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm truncate">{{ $product->name_fa }}</div>
                    <div class="text-xs text-gray-400">{{ $product->order_items_count }} سفارش</div>
                </div>
                <div class="text-green-600 font-black text-sm">{{ number_format($product->price) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Monthly Revenue Table --}}
@if($monthlyRevenue->count())
<div class="bg-white rounded-2xl shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="font-black text-gray-800">درآمد ماهانه</h3>
    </div>
    <div class="p-6">
        <div class="space-y-3">
            @foreach($monthlyRevenue as $month)
            @php $maxRevenue = $monthlyRevenue->max('revenue'); @endphp
            <div class="flex items-center gap-4">
                <div class="w-20 text-sm font-medium text-gray-600 flex-shrink-0">{{ $month->month }}</div>
                <div class="flex-1 bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-full rounded-full transition-all duration-500"
                        style="width: {{ $maxRevenue > 0 ? round(($month->revenue / $maxRevenue) * 100) : 0 }}%"></div>
                </div>
                <div class="text-sm font-black text-gray-800 w-32 text-left">{{ number_format($month->revenue) }}</div>
                <div class="text-xs text-gray-400 w-16">{{ $month->count }} سفارش</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Livewire Reviews Management --}}
<div class="mt-6">
    <div class="bg-white rounded-2xl shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="font-black text-gray-800">مدیریت نظرات</h3>
        </div>
        <div class="p-6">
            @livewire('admin-reviews')
        </div>
    </div>
</div>
@endsection

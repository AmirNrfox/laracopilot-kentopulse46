@extends('layouts.admin')
@section('title','کوپن‌ها')
@section('page-title','مدیریت کوپن‌های تخفیف')
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.coupons.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl">➕ کوپن جدید</a>
</div>
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-right font-medium text-gray-600">کد</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">نوع / مقدار</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">حداقل خرید</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">استفاده</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">انقضا</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">وضعیت</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">عملیات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($coupons as $coupon)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono font-black text-green-700">{{ $coupon->code }}</td>
                <td class="px-5 py-3">
                    @if($coupon->type === 'percent')
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">{{ $coupon->value }}%</span>
                    @else
                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded text-xs font-bold">{{ number_format($coupon->value) }} ت</span>
                    @endif
                </td>
                <td class="px-5 py-3 text-gray-600">{{ $coupon->min_order ? number_format($coupon->min_order) : '—' }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $coupon->expires_at ? $coupon->expires_at->format('Y/m/d') : 'بدون انقضا' }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $coupon->isValid() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $coupon->isValid() ? '✅ فعال' : '❌ غیرفعال' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="text-blue-600 hover:underline text-xs">✏️ ویرایش</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('حذف شود؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-8 text-gray-400">کوپنی وجود ندارد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

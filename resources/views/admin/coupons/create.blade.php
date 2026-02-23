@extends('layouts.admin')
@section('title','ایجاد کوپن')
@section('page-title','ایجاد کوپن تخفیف جدید')
@section('content')
<div class="max-w-xl">
<form action="{{ route('admin.coupons.store') }}" method="POST">
@csrf
<div class="bg-white rounded-2xl shadow p-6 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">کد تخفیف (انگلیسی، بزرگ) *</label>
        <input type="text" name="code" value="{{ old('code') }}" required dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none uppercase font-mono" placeholder="SUMMER20">
        @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">نوع *</label>
            <select name="type" class="w-full border-2 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="percent">درصدی (%)</option>
                <option value="fixed">مبلغ ثابت (تومان)</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">مقدار *</label>
            <input type="number" name="value" value="{{ old('value') }}" required min="1" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">حداقل خرید (تومان)</label>
            <input type="number" name="min_order" value="{{ old('min_order', 0) }}" min="0" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">حداکثر استفاده</label>
            <input type="number" name="max_uses" value="{{ old('max_uses') }}" min="1" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="بدون محدودیت">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">تاریخ انقضا</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" dir="ltr">
    </div>
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" name="active" value="1" checked class="w-5 h-5 accent-green-600">
        <span class="text-sm font-medium">فعال</span>
    </label>
    <div class="flex gap-3">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl">💾 ذخیره</button>
        <a href="{{ route('admin.coupons.index') }}" class="bg-gray-100 text-gray-700 font-bold py-2.5 px-6 rounded-xl">انصراف</a>
    </div>
</div>
</form>
</div>
@endsection

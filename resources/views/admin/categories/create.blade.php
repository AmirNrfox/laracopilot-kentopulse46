@extends('layouts.admin')
@section('title','افزودن دسته‌بندی')
@section('page-title','افزودن دسته‌بندی جدید')
@section('content')
<div class="max-w-xl">
<form action="{{ route('admin.categories.store') }}" method="POST">
@csrf
<div class="bg-white rounded-2xl shadow p-6 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">نام فارسی *</label>
        <input type="text" name="name_fa" value="{{ old('name_fa') }}" required class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">English Name *</label>
        <input type="text" name="name_en" value="{{ old('name_en') }}" required dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ترتیب نمایش</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none">
    </div>
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" name="active" value="1" checked class="w-5 h-5 accent-green-600">
        <span class="text-sm font-medium">فعال</span>
    </label>
    <div class="flex gap-3">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-xl">💾 ذخیره</button>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl">انصراف</a>
    </div>
</div>
</form>
</div>
@endsection

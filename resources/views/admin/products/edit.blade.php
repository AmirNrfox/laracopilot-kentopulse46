@extends('layouts.admin')
@section('title', 'ویرایش محصول')
@section('page-title', 'ویرایش: ' . $product->name_fa)

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black text-gray-800 mb-5">اطلاعات اصلی</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام فارسی *</label>
                    <input type="text" name="name_fa" value="{{ old('name_fa', $product->name_fa) }}" required class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">English Name *</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">برند</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">قیمت اصلی *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">قیمت تخفیف</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">موجودی *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black text-gray-800 mb-4">توضیحات</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">توضیح کوتاه فارسی</label>
                    <textarea name="short_description_fa" rows="2" class="w-full border-2 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('short_description_fa', $product->short_description_fa) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Description (EN)</label>
                    <textarea name="short_description_en" rows="2" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('short_description_en', $product->short_description_en) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">توضیح کامل فارسی</label>
                    <textarea name="description_fa" rows="5" class="w-full border-2 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('description_fa', $product->description_fa) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Description (EN)</label>
                    <textarea name="description_en" rows="5" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('description_en', $product->description_en) }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="space-y-5">
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-4">تنظیمات</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی *</label>
                    <select name="category_id" required class="w-full border-2 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                        <option value="">انتخاب کنید</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name_fa }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', $product->active) ? 'checked' : '' }} class="w-5 h-5 accent-green-600 rounded">
                    <span class="text-sm font-medium">فعال</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="w-5 h-5 accent-yellow-500 rounded">
                    <span class="text-sm font-medium">⭐ محصول ویژه</span>
                </label>
            </div>
        </div>
        @if($product->main_image)
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-3">تصویر فعلی</h3>
            <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-32 object-contain rounded-xl bg-gray-50 p-2">
        </div>
        @endif
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-3">{{ $product->main_image ? 'تغییر تصویر' : 'تصویر اصلی' }}</h3>
            <input type="file" name="main_image" accept="image/*" class="w-full text-sm text-gray-500 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-black py-3 rounded-xl">💾 ذخیره</button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl">انصراف</a>
        </div>
    </div>
</div>
</form>
@endsection

@extends('layouts.admin')
@section('title', 'افزودن محصول')
@section('page-title', 'افزودن محصول جدید')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main Info --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black text-gray-800 mb-5">اطلاعات اصلی</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام فارسی *</label>
                    <input type="text" name="name_fa" value="{{ old('name_fa') }}" required class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    @error('name_fa')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">English Name *</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    @error('name_en')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">برند</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none font-mono">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">قیمت اصلی (تومان) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">قیمت تخفیف (اختیاری)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price') }}" min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">موجودی *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">وزن (کیلوگرم)</label>
                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" dir="ltr" class="w-full border-2 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="font-black text-gray-800 mb-4">توضیحات</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">توضیح کوتاه فارسی</label>
                    <textarea name="short_description_fa" rows="2" maxlength="500" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none text-sm">{{ old('short_description_fa') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Description (English)</label>
                    <textarea name="short_description_en" rows="2" maxlength="500" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none text-sm">{{ old('short_description_en') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">توضیح کامل فارسی</label>
                    <textarea name="description_fa" rows="5" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none text-sm">{{ old('description_fa') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Description (English)</label>
                    <textarea name="description_en" rows="5" dir="ltr" class="w-full border-2 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none text-sm">{{ old('description_en') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Variants --}}
        <div class="bg-white rounded-2xl shadow p-6" x-data="variantManager()" x-init="init()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-black text-gray-800">وریانت‌ها (طعم / سایز)</h3>
                <button type="button" @click="add()" class="bg-blue-50 text-blue-600 text-sm font-bold px-3 py-1.5 rounded-lg hover:bg-blue-100">+ افزودن</button>
            </div>
            <template x-for="(v, i) in variants" :key="i">
            <div class="grid grid-cols-5 gap-2 mb-2 items-center">
                <select :name="'variants['+i+'][type]'" x-model="v.type" class="border rounded-lg px-2 py-2 text-sm col-span-1">
                    <option value="flavor">طعم</option>
                    <option value="size">سایز</option>
                    <option value="weight">وزن</option>
                </select>
                <input type="text" :name="'variants['+i+'][value_fa]'" x-model="v.value_fa" placeholder="فارسی" class="border rounded-lg px-2 py-2 text-sm">
                <input type="text" :name="'variants['+i+'][value_en]'" x-model="v.value_en" placeholder="English" dir="ltr" class="border rounded-lg px-2 py-2 text-sm">
                <input type="number" :name="'variants['+i+'][price_modifier]'" x-model="v.price_mod" placeholder="+قیمت" class="border rounded-lg px-2 py-2 text-sm">
                <div class="flex gap-1">
                    <input type="number" :name="'variants['+i+'][stock]'" x-model="v.stock" placeholder="موجودی" class="border rounded-lg px-2 py-2 text-sm w-full">
                    <button type="button" @click="remove(i)" class="text-red-400 hover:text-red-600 px-2">✕</button>
                </div>
            </div>
            </template>
            <p x-show="variants.length === 0" class="text-gray-400 text-sm">وریانتی اضافه نشده</p>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-4">تنظیمات</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی *</label>
                    <select name="category_id" required class="w-full border-2 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none text-sm">
                        <option value="">انتخاب کنید</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name_fa }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', '1') ? 'checked' : '' }} class="w-5 h-5 accent-green-600 rounded">
                    <span class="text-sm font-medium">فعال (نمایش در سایت)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="w-5 h-5 accent-yellow-500 rounded">
                    <span class="text-sm font-medium">⭐ محصول ویژه</span>
                </label>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-4">تصویر اصلی</h3>
            <input type="file" name="main_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-0 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
        </div>

        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="font-black text-gray-800 mb-4">SEO</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="3" maxlength="500" class="w-full border-2 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-black py-3 rounded-xl transition-colors">💾 ذخیره</button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition-colors">انصراف</a>
        </div>
    </div>
</div>
</form>

@section('scripts')
<script>
function variantManager() {
    return {
        variants: [],
        init() { this.variants = []; },
        add() { this.variants.push({ type: 'flavor', value_fa: '', value_en: '', price_mod: 0, stock: 0 }); },
        remove(i) { this.variants.splice(i, 1); }
    };
}
</script>
@endsection
@endsection

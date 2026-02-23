@extends('layouts.admin')
@section('title','دسته‌بندی‌ها')
@section('page-title','مدیریت دسته‌بندی‌ها')
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.categories.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl">➕ دسته‌بندی جدید</a>
</div>
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-right font-medium text-gray-600">نام</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">محصولات</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">ترتیب</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">وضعیت</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">عملیات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <div class="font-medium">{{ $cat->name_fa }}</div>
                    <div class="text-xs text-gray-400 font-mono">{{ $cat->name_en }} / {{ $cat->slug }}</div>
                </td>
                <td class="px-5 py-3 font-bold text-green-700">{{ $cat->products_count }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $cat->sort_order }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $cat->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $cat->active ? 'فعال' : 'غیرفعال' }}</span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-blue-600 hover:underline text-xs">✏️ ویرایش</a>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('حذف شود؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">🗑 حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-8 text-gray-400">دسته‌بندی وجود ندارد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

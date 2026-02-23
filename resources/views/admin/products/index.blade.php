@extends('layouts.admin')
@section('title', 'مدیریت محصولات')
@section('page-title', 'محصولات')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500 text-sm">{{ $products->total() }} محصول</p>
    <a href="{{ route('admin.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl transition-colors flex items-center gap-2">
        ➕ محصول جدید
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">محصول</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">دسته</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">قیمت</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">موجودی</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">وضعیت</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-contain p-1"
                                    onerror="this.style.display='none'">
                            </div>
                            <div>
                                <div class="font-medium">{{ $product->name_fa }}</div>
                                <div class="text-xs text-gray-400">{{ $product->brand }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->category?->name_fa ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($product->sale_price)
                            <div class="text-red-600 font-bold">{{ number_format($product->sale_price) }}</div>
                            <div class="text-gray-300 text-xs line-through">{{ number_format($product->price) }}</div>
                        @else
                            <div class="font-medium">{{ number_format($product->price) }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-bold {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-orange-500' : 'text-green-600') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $product->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $product->active ? '✅ فعال' : '⏸ غیرفعال' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs">✏️ ویرایش</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('حذف شود؟')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 font-medium text-xs">🗑 حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">محصولی وجود ندارد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection

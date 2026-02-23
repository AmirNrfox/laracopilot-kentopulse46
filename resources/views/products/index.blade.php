@extends('layouts.app')
@section('title', (app()->getLocale() === 'fa' ? 'همه محصولات' : 'All Products') . ' | ' . (app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa') : \App\Models\Setting::get('site_name_en')))
@section('meta_description', app()->getLocale() === 'fa' ? 'خرید انواع مکمل‌های ورزشی: پروتئین، کراتین، پیش تمرین، ویتامین، BCAA و چربی سوز با بهترین قیمت' : 'Buy sports supplements: Protein, Creatine, Pre-workout, Vitamins, BCAA and Fat Burners at best price')

@section('schema_markup')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ app()->getLocale() === 'fa' ? 'همه محصولات' : 'All Products' }}",
    "url": "{{ route('products.index') }}"
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900">{{ app()->getLocale() === 'fa' ? '🛍️ همه محصولات' : '🛍️ All Products' }}</h1>
        <p class="text-gray-500 mt-1">{{ app()->getLocale() === 'fa' ? 'مکمل‌های ورزشی اصل با ضمانت کیفیت' : 'Original sports supplements with quality guarantee' }}</p>
    </div>
    @livewire('product-filter')
</div>
@endsection

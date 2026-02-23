@extends('layouts.app')
@section('title', (app()->getLocale() === 'fa' ? 'سبد خرید' : 'Shopping Cart') . ' | ' . (app()->getLocale() === 'fa' ? \App\Models\Setting::get('site_name_fa') : \App\Models\Setting::get('site_name_en')))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-black mb-8">🛒 {{ app()->getLocale() === 'fa' ? 'سبد خرید' : 'Shopping Cart' }}</h1>
    @livewire('cart-page')
</div>
@endsection

@extends('layouts.admin')
@section('title','کاربران')
@section('page-title','مدیریت کاربران')
@section('content')
<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو (نام یا ایمیل)..." class="border-2 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none flex-1">
    <button class="bg-green-600 text-white font-bold py-2 px-5 rounded-xl">🔍</button>
    <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 font-bold py-2 px-4 rounded-xl">پاک</a>
</form>
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-right font-medium text-gray-600">کاربر</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">سفارشات</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">عضویت</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">وضعیت</th>
                <th class="px-5 py-3 text-right font-medium text-gray-600">عملیات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-green-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ mb_substr($user->name, 0, 1) }}</div>
                        <div>
                            <div class="font-medium">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3 font-bold text-green-700">{{ $user->orders_count }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->created_at->format('Y/m/d') }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $user->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->active ? 'فعال' : 'مسدود' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline text-xs">مشاهده</a>
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="active" value="{{ $user->active ? 0 : 1 }}">
                            <button class="text-xs {{ $user->active ? 'text-red-500 hover:underline' : 'text-green-600 hover:underline' }}">
                                {{ $user->active ? '🔒 مسدود' : '✅ فعال' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-8 text-gray-400">کاربری یافت نشد</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection

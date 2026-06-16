@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="flex items-center justify-between mb-6 slide-up">
    <h1 class="text-2xl font-display font-bold text-gray-900">{{ __('ui.admin_dashboard') }}</h1>
    <span class="text-xs text-gray-400">{{ __('ui.admin_terakhir_update') }} {{ now()->isoFormat('dddd, D MMMM Y - HH:mm') }}</span>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">👥</span><span class="text-xs text-green-500 font-medium">+{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }} {{ __('ui.minggu_ini') }}</span></div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.admin_total_user') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">✍️</span></div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_recipes'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.admin_total_resep') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">📣</span></div>
        <p class="text-3xl font-bold text-green-600">{{ $stats['published_recipes'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.published_count') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">📋</span></div>
        <p class="text-3xl font-bold text-amber-500">{{ $stats['draft_recipes'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.draft_count_label') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">💭</span></div>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_reviews'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.admin_total_review') }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">⭐</span></div>
        <p class="text-3xl font-bold text-amber-500">{{ $stats['avg_rating'] }}</p><p class="text-gray-400 text-xs mt-1">{{ __('ui.admin_rata_rating') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">{{ __('ui.admin_resep_terbaru') }}</h2>
            <a href="{{ route('admin.recipes') }}" class="text-amber-500 hover:text-amber-600 text-sm font-medium transition-colors">{{ __('ui.admin_lihat_semua') }} →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($stats['recent_recipes'] as $recipe)
                <div class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                    <div class="min-w-0 flex-1">
                        <a href="{{ route('recipes.show', $recipe) }}" class="font-medium text-gray-900 hover:text-walnut-500 text-sm line-clamp-1">{{ $recipe->getLocalizedTitle() }}</a>
                        <p class="text-xs text-gray-400 mt-0.5">{{ __('ui.admin_resep_oleh') }} {{ $recipe->user->name }} · {{ $recipe->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="badge text-xs flex-shrink-0 ml-3 {{ $recipe->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $recipe->status }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">{{ __('ui.admin_user_terbaru') }}</h2>
            <a href="{{ route('admin.users') }}" class="text-amber-500 hover:text-amber-600 text-sm font-medium transition-colors">{{ __('ui.admin_lihat_semua') }} →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($stats['recent_users'] as $user)
                <div class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-amber-100 rounded-full flex items-center justify-center font-bold text-amber-700 text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900 text-sm">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="badge text-xs flex-shrink-0 ml-3 {{ $user->banned_at ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">{{ $user->banned_at ? __('ui.admin_banned') : __('ui.admin_active') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

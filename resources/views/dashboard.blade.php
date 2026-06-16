@extends('layouts.app')

@section('title', 'Resep Saya - Dashboard')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-walnut-800 via-walnut-700 to-walnut-900">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-10 w-72 h-72 bg-amber-400 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-orange-400 rounded-full blur-[120px]"></div>
    </div>
    <div class="absolute inset-0">
        <img src="{{ asset('storage/sampul/sampuldalam.webp') }}" class="w-full h-full object-cover opacity-15" style="object-position: 50% 25%;">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 slide-up">
            <div>
                <p class="text-cream-300/50 text-sm mb-1 tracking-wide">✍️ {{ __('ui.dapur_kamu') }}</p>
                <h1 class="text-3xl md:text-4xl font-display font-extrabold text-white">{{ __('ui.dashboard_title') }}</h1>
                <p class="text-cream-300/60 text-sm mt-2">{{ __('ui.kelola_pantau_resep') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-walnut-900 font-bold px-6 py-3 rounded-2xl transition-all duration-300 shadow-xl shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:scale-95">
                    {{ __('ui.buat_resep_baru') }}
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-12">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @php
        $statCards = [
            ['icon' => '✍️', 'label' => __('ui.total_resep'), 'value' => $totalRecipes, 'bg' => 'from-blue-50 to-indigo-50 border-blue-100', 'iconBg' => 'bg-blue-100 text-blue-600', 'emoji' => '✨'],
            ['icon' => '📣', 'label' => __('ui.published_count'), 'value' => $totalRecipes - $draftCount, 'bg' => 'from-emerald-50 to-teal-50 border-emerald-100', 'iconBg' => 'bg-emerald-100 text-emerald-600', 'emoji' => '✨'],
            ['icon' => '📋', 'label' => __('ui.draft_count_label'), 'value' => $draftCount, 'bg' => 'from-amber-50 to-orange-50 border-amber-100', 'iconBg' => 'bg-amber-100 text-amber-600', 'emoji' => '💿'],
            ['icon' => '⭐', 'label' => __('ui.rata_rata_rating'), 'value' => number_format($avgRating ?? 0, 1), 'bg' => 'from-purple-50 to-pink-50 border-purple-100', 'iconBg' => 'bg-purple-100 text-purple-600', 'emoji' => '🏆'],
        ];
        @endphp
        @foreach($statCards as $card)
        <div class="bg-gradient-to-br {{ $card['bg'] }} rounded-2xl p-5 border shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 hover-lift">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 {{ $card['iconBg'] }} rounded-2xl flex items-center justify-center text-xl shadow-sm">{{ $card['icon'] }}</div>
                <span class="text-2xl opacity-60">{{ $card['emoji'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 animate-float-up">{{ $card['value'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium uppercase tracking-wider">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-amber-50/50 to-transparent">
            <h2 class="text-lg font-display font-bold text-gray-900 flex items-center gap-2">📃 {{ __('ui.daftar_resep_kamu') }}</h2>
            <div class="flex flex-wrap items-center gap-1.5 bg-gray-50 rounded-2xl p-1">
                <a href="{{ route('dashboard', ['filter' => 'all']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 {{ !request('filter') || request('filter') === 'all' ? 'bg-white text-amber-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">📃 {{ __('ui.semua') }}</a>
                <a href="{{ route('dashboard', ['filter' => 'published']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 {{ request('filter') === 'published' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">📣 {{ __('ui.published') }}</a>
                <a href="{{ route('dashboard', ['filter' => 'draft']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 {{ request('filter') === 'draft' ? 'bg-white text-amber-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">✍️ {{ __('ui.draft') }}</a>
            </div>
        </div>

        @if($myRecipes->count())
        <div class="divide-y divide-gray-50">
            @foreach($myRecipes as $recipe)
            <div class="p-5 hover:bg-amber-50/30 transition-all duration-200 flex flex-col sm:flex-row gap-5">
                <a href="{{ route('recipes.show', $recipe) }}" class="flex-shrink-0 w-full sm:w-36 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-cream-100 to-amber-50 flex items-center justify-center border border-cream-200 shadow-sm group">
                    @if($recipe->image_url)
                        <img loading="lazy" src="{{ $recipe->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <span class="text-3xl sm:text-5xl group-hover:scale-125 transition-transform duration-500">{{ $recipe->recipeable_type === 'drink' ? '🧋' : '🥘' }}</span>
                    @endif
                </a>
                <div class="flex-1 min-w-0 flex flex-col justify-center">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="badge-pill {{ $recipe->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $recipe->status === 'published' ? '📣 '.__('ui.published') : '✍️ '.__('ui.draft') }}
                        </span>
                        <span class="badge-pill bg-gray-100 text-gray-600">{{ $recipe->recipeable_type === 'drink' ? '🧋 '.__('ui.minuman') : '🥘 '.__('ui.makanan') }}</span>
                        @foreach($recipe->categories->take(2) as $cat)
                            <span class="badge-pill bg-purple-50 text-purple-600 border border-purple-100">{{ $cat->getLocalizedName() }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('recipes.show', $recipe) }}" class="font-bold text-gray-900 hover:text-amber-600 transition-colors text-lg line-clamp-1 mb-1.5">{{ $recipe->getLocalizedTitle() }}</a>
                    <p class="text-sm text-gray-400 line-clamp-1 mb-3">{{ Str::limit($recipe->getLocalizedDescription(), 120) }}</p>
                    <div class="flex items-center gap-5 text-xs text-gray-400">
                        <span class="flex items-center gap-1 font-bold text-amber-500">⭐ {{ number_format($recipe->avg_rating, 1) }}</span>
                        <span>💭 {{ $recipe->reviews_count ?? $recipe->reviews->count() }} review</span>
                        <span class="hidden sm:inline">🕒 {{ $recipe->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex sm:flex-col gap-2 items-stretch sm:items-center sm:justify-center flex-shrink-0">
                    <a href="{{ route('recipes.show', $recipe) }}" class="flex items-center justify-center gap-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 text-xs font-bold py-2.5 px-4 rounded-xl transition-all duration-200">👀 {{ __('ui.lihat') }}</a>
                    <a href="{{ route('recipes.edit', $recipe) }}" class="flex items-center justify-center gap-1.5 bg-sky-50 hover:bg-sky-100 text-sky-600 hover:text-sky-700 text-xs font-bold py-2.5 px-4 rounded-xl transition-all duration-200">✍️ {{ __('ui.edit') }}</a>
                    <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('⚠️ {{ __('ui.hapus') }} {{ $recipe->title }}?')" class="sm:w-full">
                        @csrf @method('DELETE')
                        <button class="flex items-center justify-center gap-1.5 w-full bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 text-xs font-bold py-2.5 px-4 rounded-xl transition-all duration-200">🗑 {{ __('ui.hapus') }}</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-5 border-t border-gray-100 bg-gray-50/50 flex justify-center">
            {{ $myRecipes->appends(request()->query())->links() }}
        </div>
        @else
        <div class="py-12 sm:py-20 text-center">
            <span class="text-4xl sm:text-7xl block mb-4 sm:mb-6">{{ request('filter') === 'draft' ? '📋' : '🔥' }}</span>
            <h3 class="text-2xl font-display font-bold text-gray-400 mb-2">
                {{ request('filter') === 'draft' ? __('ui.tidak_ada_draft') : __('ui.belum_ada_resep') }}
            </h3>
            <p class="text-gray-300 mb-8 max-w-sm mx-auto">{{ request('filter') === 'draft' ? __('ui.semua_sudah_published') : __('ui.saatnya_berbagi') }}</p>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-walnut-900 font-bold px-8 py-3.5 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-amber-500/30 hover:-translate-y-0.5 active:scale-95 text-lg">
                {{ __('ui.buat_resep_pertama') }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

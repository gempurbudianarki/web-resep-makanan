@extends('layouts.app')

@section('title', 'Beranda · BagiResep')

@section('content')
<div class="relative bg-walnut-800 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/sampul/sampuldalam.webp') }}" class="w-full h-full object-cover opacity-40" style="object-position: 50% 25%;">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-walnut-900/80 via-walnut-800/50 to-walnut-700/30"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 slide-up">
            <div>
                <p class="text-cream-300/60 text-sm mb-1 tracking-wide">{{ __('ui.selamat_datang') }}</p>
                <h1 class="text-2xl md:text-3xl font-display font-bold text-white">{{ auth()->user()->name }}</h1>
                <p class="text-cream-300/60 text-sm mt-2">{{ __('ui.kelola_resep') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('recipes.create') }}" class="btn-primary gap-2 shadow-xl hover:shadow-amber-500/30">+ {{ __('ui.buat_resep_baru') }}</a>
                <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl font-medium text-sm transition-all duration-300 border border-white/10 backdrop-blur">
                    {{ __('ui.admin_jelajahi_resep') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-10 slide-up" style="animation-delay: 0.1s">
            @php
                $stats = [
                    ['label' => __('ui.resep_dibuat'), 'value' => $recipeStats->total ?? 0, 'color' => 'white'],
                    ['label' => __('ui.rata_rating'), 'value' => '★ ' . number_format($recipeStats->avg_rating ?? 0, 1), 'color' => 'amber'],
                    ['label' => 'Bookmark', 'value' => $bookmarkCount, 'color' => 'white'],
                    ['label' => 'Review', 'value' => $reviewCount, 'color' => 'white'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 border border-white/10 hover:bg-white/15 transition-all duration-300 hover:-translate-y-0.5">
                    <p class="text-cream-300/60 text-xs uppercase tracking-wider font-medium mb-1">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold {{ $stat['color'] === 'amber' ? 'text-amber-400' : 'text-white' }}">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            @if($myRecipes->count())
                <div class="slide-up">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-display font-bold text-charcoal-500">{{ __('ui.resep_terbaru_kamu') }}</h2>
                            <p class="text-gray-400 text-sm mt-0.5">{{ $recipeStats->total ?? 0 }} {{ __('ui.resep') }} &middot; {{ $recipeStats->draft_count ?? 0 }} {{ __('ui.draft_count') }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="text-amber-500 hover:text-amber-600 text-sm font-semibold flex items-center gap-1 transition-all duration-300 hover:gap-2">{{ __('ui.lihat_semua') }} <span>→</span></a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($myRecipes as $recipe)
                            <a href="{{ route('recipes.show', $recipe) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg hover:border-amber-200 hover:-translate-y-1 transition-all duration-300 flex">
                                <div class="w-28 h-28 flex-shrink-0 bg-cream-100 flex items-center justify-center overflow-hidden">
                                    @if($recipe->image_url)
                                        <img loading="lazy" src="{{ $recipe->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="flex items-center justify-center w-full h-full">
                                            <svg class="w-8 h-8 text-walnut-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 p-4 min-w-0 flex flex-col justify-center">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-medium {{ $recipe->status === 'published' ? 'text-green-600' : 'text-amber-500' }}">{{ $recipe->status === 'published' ? __('ui.published') : __('ui.draft') }}</span>
                                    </div>
                                    <h3 class="font-semibold text-charcoal-500 group-hover:text-walnut-500 transition-colors duration-300 text-sm line-clamp-2 leading-snug">{{ $recipe->getLocalizedTitle() }}</h3>
                                    <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-400">
                                        <span class="flex items-center gap-0.5"><span class="text-amber-400">★</span> {{ number_format($recipe->avg_rating, 1) }}</span>
                                        <span>{{ $recipe->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-12 text-center slide-up">
                    <div class="w-16 h-16 bg-cream-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-walnut-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-charcoal-500 mb-2">{{ __('ui.belum_ada_resep') }}</h3>
                    <p class="text-gray-400 text-sm mb-5 max-w-sm mx-auto">{{ __('ui.belum_resep_deskripsi') }}</p>
                    <a href="{{ route('recipes.create') }}" class="btn-primary text-sm">{{ __('ui.buat_resep_pertama') }}</a>
                </div>
            @endif

            <div class="slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-display font-bold text-charcoal-500">{{ __('ui.resep_populer') }}</h2>
                        <p class="text-gray-400 text-sm mt-0.5">{{ __('ui.rating_tertinggi') }}</p>
                    </div>
                    <a href="{{ route('recipes.index', ['sort' => 'rating']) }}" class="text-amber-500 hover:text-amber-600 text-sm font-semibold flex items-center gap-1 transition-all duration-300 hover:gap-2">{{ __('ui.jelajahi') }} <span>→</span></a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($popularRecipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg hover:border-amber-200 hover:-translate-y-1 transition-all duration-300">
                            <div class="aspect-[4/3] bg-cream-100 flex items-center justify-center overflow-hidden relative">
                                @if($recipe->image_url)
                                    <img loading="lazy" src="{{ $recipe->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <svg class="w-12 h-12 text-walnut-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                @endif
                                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur rounded-lg px-2 py-0.5 text-xs font-bold text-amber-500 flex items-center gap-1 shadow-sm">
                                    ★ {{ number_format($recipe->avg_rating, 1) }}
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-charcoal-500 group-hover:text-walnut-500 transition-colors duration-300 text-sm line-clamp-2 leading-snug mb-1.5">{{ $recipe->getLocalizedTitle() }}</h3>
                                <p class="text-xs text-gray-400">{{ __('ui.oleh') }} {{ $recipe->user->name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm slide-up" style="animation-delay: 0.15s">
                <h3 class="font-bold text-charcoal-500 text-sm mb-4">{{ __('ui.review_terbaru_kamu') }}</h3>
                @forelse($recentReviews as $review)
                    <a href="{{ route('recipes.show', $review->recipe) }}" class="block py-2.5 border-b border-gray-50 last:border-0 hover:bg-cream-50 -mx-2 px-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center gap-0.5 mb-1">
                            @for($i=1;$i<=5;$i++)<span class="text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>@endfor
                        </div>
                        <p class="text-xs text-charcoal-500 font-medium line-clamp-1">{{ $review->recipe->title }}</p>
                        @if($review->comment)
                            <p class="text-xs text-gray-400 line-clamp-1 mt-0.5 italic">{{ Str::limit($review->comment, 60) }}</p>
                        @endif
                        <p class="text-xs text-gray-300 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="text-xs text-gray-400 text-center py-6">{{ __('ui.kamu_belum_review') }}</p>
                @endforelse
            </div>

            <div class="bg-gradient-to-br from-walnut-500 to-walnut-600 rounded-2xl p-6 text-white shadow-lg slide-up" style="animation-delay: 0.2s">
                <h3 class="font-bold text-lg mb-1">{{ __('ui.punya_resep_andalan') }}</h3>
                <p class="text-cream-300 text-sm mb-5 leading-relaxed">{{ __('ui.bagikan_resep_spesial') }}</p>
                <a href="{{ route('recipes.create') }}" class="inline-flex items-center justify-center gap-2 bg-amber-400 hover:bg-amber-300 text-walnut-800 px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 hover:-translate-y-0.5 w-full">
                    + {{ __('ui.buat_resep_sekarang') }}
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm slide-up" style="animation-delay: 0.25s">
                <h3 class="font-bold text-charcoal-500 text-sm mb-3">{{ __('ui.kategori_populer') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @php $cats = \App\Models\Category::withCount('recipes')->orderBy('recipes_count','desc')->take(6)->get(); @endphp
                    @foreach($cats as $cat)
                        <a href="{{ route('recipes.index', ['category_id' => $cat->id]) }}" class="text-xs font-medium bg-cream-50 hover:bg-cream-100 text-walnut-500 px-3 py-1.5 rounded-lg transition-all duration-200 border border-cream-200 hover:border-amber-200 hover:-translate-y-0.5">
                            {{ $cat->getLocalizedName() }} <span class="text-gray-400 ml-1">({{ $cat->recipes_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

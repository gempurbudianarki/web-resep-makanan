@extends('layouts.app')

@section('title', 'Jelajahi Resep · BagiResep')
@section('meta_description', 'Jelajahi ratusan resep masakan Indonesia dari berbagai kategori. Temukan inspirasi masakan rumahan, kue, minuman, dan banyak lagi.')
@section('meta_keywords', 'cari resep, resep masakan indonesia, resep rumahan, resep kue, resep minuman, kuliner nusantara')

@push('scripts')
<script>
function infiniteScroll() {
    return {
        track: null, pos: 0, speed: 0.5, trackWidth: 0, anim: null, running: true,
        init() {
            this.track = document.getElementById('featured-track');
            if (!this.track) return;
            const container = document.getElementById('featured-scroll');
            const originalItems = Array.from(this.track.children);
            if (!originalItems.length) return;

            const originalWidth = this.track.scrollWidth;

            const cloneItems = () => {
                originalItems.forEach(child => {
                    const clone = child.cloneNode(true);
                    this.track.appendChild(clone);
                });
            };

            cloneItems();
            while (this.track.scrollWidth < (container.clientWidth * 3) && this.track.children.length < 80) {
                cloneItems();
            }

            this.trackWidth = originalWidth;
            this.loop();
        },
        loop() {
            if (this.running && this.trackWidth > 0) {
                this.pos += this.speed;
                if (this.pos >= this.trackWidth) {
                    this.pos -= this.trackWidth;
                }
                this.track.style.transform = `translateX(${-this.pos}px)`;
            }
            this.anim = requestAnimationFrame(() => this.loop());
        },
        start() { this.running = true; },
        stop() { this.running = false; },
    };
}
</script>
@endpush

@section('content')
<section class="relative overflow-hidden bg-walnut-800">
    <div class="absolute inset-0">
        <img src="{{ asset('storage/sampul/sampuldalam.webp') }}" class="w-full h-full object-cover opacity-30" style="object-position: 50% 25%;">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-walnut-900/70 via-walnut-800/50 to-walnut-700/60"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="text-center max-w-2xl mx-auto slide-up">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-display font-bold text-white mb-3">{{ __('ui.jelajahi_resep') }}</h1>
            <p class="text-cream-300/80 text-base sm:text-lg">{{ __('ui.temukan_inspirasi') }}</p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-4">
    <form method="GET" action="{{ route('recipes.index') }}" class="bg-white rounded-2xl shadow-xl shadow-black/10 p-2 sm:p-2.5 flex flex-col sm:flex-row gap-2 mb-8 slide-up">
        <div class="flex-1 relative">
            <svg class="absolute left-3.5 sm:left-4 top-1/2 -translate-y-1/2 w-4 sm:w-5 h-4 sm:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari resep..."
                   class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3.5 bg-transparent text-charcoal-500 placeholder-gray-400 focus:outline-none text-sm sm:text-[15px]">
        </div>
        <div class="flex gap-1.5 sm:gap-2">
            <select name="category_id" class="flex-1 sm:flex-none bg-cream-50 border-0 rounded-xl px-2.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-charcoal-500 focus:ring-2 focus:ring-amber-400 cursor-pointer transition-all duration-200 hover:bg-cream-100 min-w-0" onchange="this.form.submit()">
                <option value="">{{ __('ui.semua_kategori') }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->getLocalizedName() }}</option>
                @endforeach
            </select>
            <select name="sort" class="flex-1 sm:flex-none bg-cream-50 border-0 rounded-xl px-2.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-charcoal-500 focus:ring-2 focus:ring-amber-400 cursor-pointer transition-all duration-200 hover:bg-cream-100 min-w-0" onchange="this.form.submit()">
                <option value="rating" {{ request('sort', 'rating') === 'rating' ? 'selected' : '' }}>⭐</option>
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>🕒</option>
            </select>
        </div>
    </form>

    @if(request('search') || request('category_id'))
        <div class="flex flex-wrap items-center gap-2 mb-8 fade-in">
            <span class="text-sm text-gray-400">{{ __('ui.filter') }}</span>
            @if(request('search'))
                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-medium px-3 py-1.5 rounded-full">
                    "{{ request('search') }}"
                    <a href="{{ route('recipes.index', array_filter(['category_id' => request('category_id'), 'sort' => request('sort')])) }}" class="hover:text-amber-900 font-bold ml-1">&times;</a>
                </span>
            @endif
            @if(request('category_id'))
                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-medium px-3 py-1.5 rounded-full">
                    {{ $categories->find(request('category_id'))?->getLocalizedName() }}
                    <a href="{{ route('recipes.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" class="hover:text-amber-900 font-bold ml-1">&times;</a>
                </span>
            @endif
            <a href="{{ route('recipes.index') }}" class="text-xs text-gray-400 hover:text-gray-600 ml-2 underline transition-colors">{{ __('ui.reset') }}</a>
        </div>
    @endif

    @if(!request('search') && !request('category_id') && $featuredRecipes->count())
    <div class="mb-8 slide-up">
        <div class="flex items-center justify-between mb-4 sm:mb-5">
            <h2 class="text-lg sm:text-xl font-display font-bold text-charcoal-500">{{ __('ui.resep_unggulan') }}</h2>
            <div class="hidden sm:flex items-center gap-2">
                <button onclick="document.getElementById('featured-scroll').scrollBy({left: -300, behavior: 'smooth'})" class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="document.getElementById('featured-scroll').scrollBy({left: 300, behavior: 'smooth'})" class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-gray-50 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        <div id="featured-scroll" class="overflow-hidden pb-4" x-data="infiniteScroll()" x-init="init()" @mouseenter="stop()" @mouseleave="start()">
            <div id="featured-track" class="flex gap-4 will-change-transform" style="width: max-content;">
                @foreach($featuredRecipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="group bg-white rounded-2xl border border-gray-100 hover:border-amber-200 hover:shadow-xl transition-all duration-300 flex-shrink-0 w-60 sm:w-64 overflow-hidden">
                    <div class="relative overflow-hidden h-32 sm:h-40">
                        @if($recipe->image_url)
                            <img loading="lazy" src="{{ $recipe->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-walnut-100 via-cream-100 to-amber-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-walnut-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-amber-400 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow">★ {{ number_format($recipe->avg_rating, 1) }}</div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-semibold text-charcoal-500 group-hover:text-walnut-500 transition-colors duration-300 text-sm line-clamp-2 leading-snug">{{ $recipe->getLocalizedTitle() }}</h3>
                        <p class="text-xs text-gray-400 mt-1.5">{{ __('ui.oleh') }} {{ $recipe->user->name }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(!request('search') && !request('category_id'))
    <div class="flex items-center justify-between mb-4 sm:mb-5">
        <h2 class="text-lg sm:text-xl font-display font-bold text-charcoal-500">{{ __('ui.semua_resep') }}</h2>
    </div>
    @endif

    @if($recipes->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="group bg-white rounded-2xl sm:rounded-2xl overflow-hidden border border-gray-100/80 hover:border-amber-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col hover-lift shadow-sm">
                    <div class="relative overflow-hidden aspect-[4/3] sm:aspect-auto sm:h-52 bg-cream-50">
                        @if($recipe->image_url)
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-walnut-100 via-cream-100 to-amber-100 flex items-center justify-center">
                                <span class="text-5xl sm:text-6xl opacity-25">🥘</span>
                            </div>
                        @endif
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur text-charcoal-500 text-[10px] sm:text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">
                                {{ $recipe->recipeable_type === 'drink' ? __('ui.minuman') : __('ui.makanan') }}
                            </span>
                        </div>
                        @if($recipe->avg_rating >= 4)
                            <div class="absolute top-2.5 right-2.5 bg-amber-400 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 rounded-full shadow-md">
                                ★ {{ number_format($recipe->avg_rating, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="p-3 sm:p-4 flex-1 flex flex-col">
                        <div class="flex items-center gap-1.5 mb-1.5 sm:mb-2">
                            @foreach($recipe->categories->take(2) as $cat)
                                <span class="text-[10px] sm:text-xs text-gray-400 bg-cream-50 px-2 py-0.5 rounded-full">{{ $cat->getLocalizedName() }}</span>
                            @endforeach
                        </div>
                        <h3 class="font-bold text-charcoal-500 group-hover:text-walnut-500 transition-colors duration-300 line-clamp-2 leading-snug text-sm sm:text-[15px]">{{ $recipe->getLocalizedTitle() }}</h3>
                        <p class="text-xs text-gray-400 line-clamp-2 mt-1 sm:mt-2 flex-1">{{ Str::limit($recipe->getLocalizedDescription(), 60) }}</p>
                        <div class="flex items-center justify-between pt-2.5 sm:pt-3 mt-auto border-t border-gray-50">
                            <div class="flex items-center gap-1.5">
                                <div class="w-5 h-5 sm:w-6 sm:h-6 bg-cream-100 rounded-full flex items-center justify-center text-[10px] sm:text-xs font-bold text-walnut-500">
                                    {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
                                </div>
                                <span class="text-[10px] sm:text-xs text-gray-400 truncate max-w-[80px] sm:max-w-[120px]">{{ $recipe->user->name }}</span>
                            </div>
                            <div class="flex items-center gap-0.5 sm:gap-1 text-[10px] sm:text-xs font-semibold text-charcoal-500">
                                <span class="text-amber-400">★</span> {{ number_format($recipe->avg_rating, 1) }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-12 flex justify-center fade-in">
            {{ $recipes->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 p-10 sm:p-20 text-center shadow-sm slide-up">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h3 class="text-2xl font-display font-bold text-charcoal-500 mb-3">{{ __('ui.tidak_ditemukan') }}</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">{{ __('ui.coba_kata_kunci_lain') }}</p>
            @auth
                <a href="{{ route('recipes.create') }}" class="btn-primary text-lg px-8 py-3">+ {{ __('ui.buat_resep_baru') }}</a>
            @endif
        </div>
    @endif
</div>
@endsection

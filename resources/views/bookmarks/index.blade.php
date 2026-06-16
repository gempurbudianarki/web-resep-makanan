@extends('layouts.app')

@section('title', 'Resep Tersimpan')

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-display font-bold text-charcoal-500 flex items-center gap-3">
            <span>📑</span> {{ __('ui.bookmark_title') }}
        </h1>
        <p class="text-gray-400 mt-1">{{ $bookmarks->total() }} {{ __('ui.resep_tersimpan') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($bookmarks->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($bookmarks as $recipe)
                <a href="{{ route('recipes.show', $recipe) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-amber-200 hover:shadow-xl transition-all duration-300">
                    <div class="relative overflow-hidden">
                        @if($recipe->image_url)
                            <img loading="lazy" src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-walnut-100 via-cream-100 to-amber-100 flex items-center justify-center">
                                <span class="text-6xl">{{ $recipe->recipeable_type === 'drink' ? '🧋' : '🥘' }}</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="badge bg-white/90 backdrop-blur text-charcoal-500 text-xs shadow-sm">{{ $recipe->user->name }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-charcoal-500 group-hover:text-walnut-500 transition mb-1.5 line-clamp-2 leading-snug text-[15px]">{{ $recipe->getLocalizedTitle() }}</h3>
                        <p class="text-xs text-gray-400 line-clamp-2 mb-3">{{ Str::limit($recipe->getLocalizedDescription(), 70) }}</p>
                        <div class="flex items-center gap-1 text-sm">
                            <span class="text-amber-400">★</span>
                            <span class="font-semibold text-charcoal-500">{{ number_format($recipe->avg_rating, 1) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10 flex justify-center">{{ $bookmarks->links() }}</div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 p-16 text-center shadow-sm">
            <span class="text-7xl block mb-6">📑</span>
            <h3 class="text-2xl font-display font-bold text-charcoal-500 mb-3">{{ __('ui.belum_ada_bookmark') }}</h3>
            <p class="text-gray-400 mb-8">{{ __('ui.jelajahi_untuk_menyimpan') }}</p>
            <a href="{{ route('recipes.index') }}" class="btn-primary text-lg px-8 py-3">{{ __('ui.admin_jelajahi_resep') }}</a>
        </div>
    @endif
</div>
@endsection

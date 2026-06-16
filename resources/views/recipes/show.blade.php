@extends('layouts.app')

@section('title', $recipe->title . ' · BagiResep')
@section('meta_description', Str::limit(strip_tags($recipe->description), 160))
@section('og_type', 'article')
@if($recipe->image_url)
@section('og_image', $recipe->image_url)
@endif

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Recipe",
  "name": "{{ $recipe->title }}",
  "author": {
    "@type": "Person",
    "name": "{{ $recipe->user->name }}"
  },
  "description": "{{ Str::limit(strip_tags($recipe->description), 200) }}",
  @if($recipe->image_url)"image": "{{ $recipe->image_url }}",
  @endif
  "datePublished": "{{ $recipe->created_at->toIso8601String() }}",
  @if($recipe->recipeable_type === 'food' && $recipe->recipeable)
  "cookTime": "PT{{ $recipe->recipeable->cooking_time }}M",
  "recipeYield": "{{ $recipe->recipeable->serving_size }} porsi",
  "nutrition": {
    "@type": "NutritionInformation",
    "calories": "{{ $recipe->recipeable->calories }} calories"
  },
  @endif
  "recipeIngredient": [
    @foreach($recipe->ingredients as $ing)
    "{{ $ing->pivot->amount }} {{ $ing->pivot->unit }} {{ $ing->getLocalizedName() }}"@if(!$loop->last),@endif
    @endforeach
  ],
  "recipeInstructions": [
    @foreach($recipe->getLocalizedSteps() as $step)
    {
      "@type": "HowToStep",
      "text": "{{ $step }}"
    }@if(!$loop->last),@endif
    @endforeach
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $recipe->avg_rating }}",
    "ratingCount": "{{ $reviewsCount }}",
    "bestRating": "5",
    "worstRating": "1"
  }
}
</script>
@endpush

@section('content')
@if($recipe->image_url)
<section class="relative h-[40vh] md:h-[55vh] overflow-hidden bg-walnut-700">
    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover opacity-90">
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-black/45"></div>
    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-14">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-wrap items-center gap-2.5 mb-4">
                <span class="inline-flex items-center gap-1.5 bg-amber-400 text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ $recipe->recipeable_type === 'drink' ? '🧋 ' . __('ui.minuman') : '🥘 ' . __('ui.makanan') }}</span>
                @foreach($recipe->categories as $cat)
                    <span class="inline-flex items-center bg-white/15 backdrop-blur text-white/90 text-xs px-3 py-1.5 rounded-full">{{ $cat->getLocalizedName() }}</span>
                @endforeach
            </div>
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-display font-extrabold text-white leading-tight drop-shadow-2xl">{{ $recipe->getLocalizedTitle() }}</h1>
            <div class="flex flex-wrap items-center gap-5 mt-4 text-white/80 text-sm">
                <span class="flex items-center gap-1.5"><span class="w-7 h-7 bg-amber-400 rounded-full flex items-center justify-center text-xs font-bold text-white">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</span> <span class="font-medium text-white">{{ $recipe->user->name }}</span></span>
                <span>📅 {{ $recipe->created_at->isoFormat('D MMMM Y') }}</span>
                <span class="flex items-center gap-1 text-amber-400 font-bold text-base">★ {{ number_format($recipe->avg_rating, 1) }} <span class="text-white/60 font-normal text-sm">({{ $reviewsCount }})</span></span>
            </div>
        </div>
    </div>
</section>
@endif

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 {{ $recipe->image_url ? '-mt-12' : 'pt-8' }} relative z-10 pb-12">
    @if(session('success'))
        <div class="bg-olive-50 border border-olive-200 text-olive-700 px-5 py-3.5 rounded-2xl mb-6 text-sm flex items-center justify-between shadow-sm" x-data="{show:true}" x-show="show">
            <span>✅ {{ session('success') }}</span><button @click="show=false" class="text-olive-400 hover:text-olive-600 text-lg">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-2xl {{ $recipe->image_url ? 'p-6 sm:p-10' : 'p-6 sm:p-10 border border-gray-100' }}">
        @if(!$recipe->image_url)
            <div class="flex flex-wrap items-center gap-2.5 mb-5">
                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full">{{ $recipe->recipeable_type === 'drink' ? '🧋 ' . __('ui.minuman') : '🥘 ' . __('ui.makanan') }}</span>
                @foreach($recipe->categories as $cat)
                    <span class="inline-flex items-center bg-cream-100 text-walnut-600 text-xs px-3 py-1.5 rounded-full">{{ $cat->getLocalizedName() }}</span>
                @endforeach
            </div>
            <h1 class="text-3xl md:text-4xl font-display font-extrabold text-charcoal-500 leading-tight mb-3">{{ $recipe->getLocalizedTitle() }}</h1>
            <div class="flex flex-wrap items-center gap-5 text-sm text-gray-400 mb-8">
                <span class="flex items-center gap-1.5"><span class="w-7 h-7 bg-amber-100 rounded-full flex items-center justify-center text-xs font-bold text-amber-700">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</span> <span class="font-medium text-charcoal-500">{{ $recipe->user->name }}</span></span>
                <span>📅 {{ $recipe->created_at->isoFormat('D MMMM Y') }}</span>
                <span class="flex items-center gap-1 text-amber-400">★ <span class="font-bold text-charcoal-500">{{ number_format($recipe->avg_rating, 1) }}</span></span>
            </div>
        @endif

        @if($recipe->recipeable && method_exists($recipe->recipeable, 'getRecipeDetails'))
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach(explode(' | ', $recipe->recipeable->getRecipeDetails()) as $detail)
                    @if(trim($detail))
                        <span class="inline-flex items-center gap-2 bg-cream-100 text-walnut-600 px-4 py-2 rounded-xl text-sm font-semibold shadow-sm">{{ $detail }}</span>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="text-gray-600 leading-relaxed text-[15px] mb-10 border-l-4 border-amber-400 pl-5 py-3 bg-cream-50 rounded-r-2xl italic">
            {{ $recipe->getLocalizedDescription() }}
        </div>

        @if($recipe->ingredients && $recipe->ingredients->count())
            <div class="mb-10">
                <h2 class="text-2xl font-display font-bold text-charcoal-500 mb-5 flex items-center gap-3">
                    <span class="w-11 h-11 bg-amber-100 rounded-2xl flex items-center justify-center text-xl shadow-sm">🧄</span> {{ __('ui.bahan_bahan') }}
                </h2>
                <div class="bg-cream-50 rounded-2xl p-6 border border-cream-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2">
                        @foreach($recipe->ingredients as $ingredient)
                            <div class="flex items-center justify-between py-2.5 {{ !$loop->last && ($loop->index + 1) % 2 != 0 ? 'sm:border-b border-cream-200' : '' }} {{ $loop->remaining > 1 ? 'border-b border-cream-200 sm:border-b-0' : '' }}">
                                <span class="font-medium text-charcoal-500">{{ $ingredient->getLocalizedName() }}</span>
                                <span class="text-gray-400 font-medium text-sm tabular-nums">{{ $ingredient->pivot->amount }} {{ $ingredient->pivot->unit }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @php $localizedSteps = $recipe->getLocalizedSteps(); @endphp
        @if($localizedSteps)
            <div class="mb-10">
                <h2 class="text-2xl font-display font-bold text-charcoal-500 mb-5 flex items-center gap-3">
                    <span class="w-11 h-11 bg-olive-100 rounded-2xl flex items-center justify-center text-xl shadow-sm">📃</span> {{ __('ui.langkah_langkah') }}
                </h2>
                <div class="space-y-5">
                    @foreach($recipe->steps as $index => $step)
                        <div class="flex gap-5 group">
                            <div class="flex-shrink-0 w-11 h-11 bg-amber-400 text-white rounded-2xl flex items-center justify-center font-bold shadow-md group-hover:scale-110 group-hover:bg-amber-500 transition-all duration-200">{{ $index + 1 }}</div>
                            <p class="text-gray-600 pt-2.5 leading-relaxed flex-1">{{ $step }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 pt-8 border-t border-gray-100">
            @auth
                @if(auth()->id() === $recipe->user_id || auth()->user()->hasPermissionTo('bypass-all'))
                    <a href="{{ route('recipes.edit', $recipe) }}" class="btn-secondary text-sm gap-2">✍️ {{ __('ui.edit_resep') }}</a>
                    <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('Yakin hapus {{ $recipe->title }}?')">
                        @csrf @method('DELETE')
                        <button class="btn-danger text-sm gap-2">🗑 {{ __('ui.hapus') }}</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('bookmarks.toggle', $recipe) }}">
                    @csrf
                    <button class="btn-secondary text-sm gap-2 {{ $isBookmarked ? '!bg-amber-50 !text-amber-600 !border-amber-300' : '' }}">
                        {{ $isBookmarked ? '📑 ' . __('ui.tersimpan') : '🏷 ' . __('ui.simpan_resep') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-secondary text-sm">{{ __('ui.masuk_untuk_menyimpan') }}</a>
            @endauth
            <a href="{{ route('recipes.print', $recipe) }}" target="_blank" class="btn-secondary text-sm gap-2 ml-auto">🖨 {{ __('ui.cetak') }}</a>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl p-6 sm:p-10 mt-6 border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-display font-bold text-charcoal-500 flex items-center gap-3">
                <span class="w-11 h-11 bg-amber-100 rounded-2xl flex items-center justify-center text-xl shadow-sm">⭐</span>
                {{ __('ui.review_section') }} <span class="text-amber-400 font-extrabold ml-2">{{ number_format($recipe->avg_rating, 1) }}</span>
            </h2>
            <span class="text-sm text-gray-400 bg-cream-50 px-3 py-1 rounded-full">{{ $reviewsCount }} {{ __('ui.review') }}</span>
        </div>

        @auth
            <div class="bg-cream-50 rounded-2xl p-6 mb-8 border border-cream-200" x-data="{ rating: 0, hover: 0 }">
                <h3 class="font-bold text-charcoal-500 mb-3 text-lg">{{ __('ui.bagikan_pendapat') }}</h3>
                <form method="POST" action="{{ route('reviews.store', $recipe) }}">
                    @csrf
                    <div class="flex items-center gap-1.5 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    @click="rating = {{ $i }}"
                                    @mouseenter="hover = {{ $i }}"
                                    @mouseleave="hover = 0"
                                    class="text-3xl sm:text-4xl transition-all duration-150 transform hover:scale-125 focus:outline-none"
                                    :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 drop-shadow-sm' : 'text-gray-300'">★</button>
                        @endfor
                        <input type="hidden" name="rating" :value="rating">
                        <span class="ml-3 text-sm text-gray-400 font-medium" x-show="rating > 0" x-text="rating + ' {{ __('ui.bintang') }}'"></span>
                    </div>
                    <textarea name="comment" rows="3" class="input-field mb-4" placeholder="{{ __('ui.tulis_review') }}"></textarea>
                    <button type="submit" class="btn-primary text-sm" :disabled="rating === 0">{{ __('ui.kirim_review') }}</button>
                </form>
            </div>
        @else
            <div class="bg-cream-50 rounded-2xl p-6 mb-8 text-center border border-cream-200">
                <p class="text-gray-500"><a href="{{ route('login') }}" class="text-amber-500 font-semibold hover:underline">{{ __('ui.masuk_untuk_review') }}</a></p>
            </div>
        @endauth

        <div class="divide-y divide-gray-50">
            @forelse($reviews as $review)
                <div class="flex gap-4 py-5 first:pt-0 last:pb-0 group">
                    <div class="w-11 h-11 bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl flex items-center justify-center flex-shrink-0 font-bold text-amber-700 shadow-sm">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-charcoal-500">{{ $review->user->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                                @auth
                                    @if(auth()->id() === $review->user_id || auth()->user()->hasPermissionTo('bypass-all'))
                                        <form method="POST" action="{{ route('reviews.destroy', [$recipe, $review]) }}" onsubmit="return confirm('Hapus review ini?')" class="inline-flex">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors duration-200 opacity-0 group-hover:opacity-100" title="Hapus review">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                        @if($review->comment)
                            <p class="text-gray-500 text-sm leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <span class="text-4xl sm:text-6xl block mb-4">⭐</span>
                    <h3 class="text-lg font-bold text-charcoal-500 mb-2">{{ __('ui.belum_ada_review') }}</h3>
                    <p class="text-gray-400">{{ __('ui.jadi_pertama_review') }}</p>
                </div>
            @endforelse
        </div>

        @if($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

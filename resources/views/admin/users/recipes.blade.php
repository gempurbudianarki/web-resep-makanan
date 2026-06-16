@extends('admin.layout')

@section('title', 'Resep oleh ' . $user->name)

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.users') }}" class="text-gray-400 hover:text-gray-600">← {{ __('ui.admin_kembali') }}</a>
    <h1 class="text-2xl font-display font-bold text-gray-900">{{ __('ui.admin_resep_oleh') }} {{ $user->name }}</h1>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($recipes as $recipe)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-2 mb-2">
                <span class="badge {{ $recipe->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs">
                    {{ $recipe->status }}
                </span>
                <span class="badge bg-amber-100 text-amber-700 text-xs">
                    {{ $recipe->recipeable_type === 'drink' ? '🧋 '.__('ui.minuman') : '🥘 '.__('ui.makanan') }}
                </span>
            </div>
            <a href="{{ route('recipes.show', $recipe) }}" class="font-medium text-gray-900 hover:text-walnut-500 transition-colors line-clamp-1">{{ $recipe->getLocalizedTitle() }}</a>
            <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                <span class="flex items-center gap-0.5"><span class="text-amber-400">★</span> {{ number_format($recipe->avg_rating, 1) }}</span>
                <span>{{ $recipe->reviews_count }} review</span>
                <span>{{ $recipe->created_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 text-gray-400">{{ __('ui.belum_ada_resep') }}</div>
    @endforelse
</div>
<div class="mt-6">
    {{ $recipes->links() }}
</div>
@endsection

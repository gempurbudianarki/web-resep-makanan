@extends('admin.layout')

@section('title', 'Semua Resep - Admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 slide-up">
    <h1 class="text-2xl font-display font-bold text-gray-900">{{ __('ui.semua_resep') }}</h1>
    <form method="GET" class="flex gap-2">
        <select name="status" class="input-field !py-2 !w-auto text-sm" onchange="this.form.submit()">
            <option value="">📃 {{ __('ui.admin_filter_status') }}</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>📣 {{ __('ui.published') }}</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>✍️ {{ __('ui.draft') }}</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('ui.admin_filter_cari') }}" class="input-field !py-2 !w-44 text-sm">
        <button type="submit" class="btn-primary text-sm">{{ __('ui.admin_filter_btn') }}</button>
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_resep') }}</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_penulis') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_tipe') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_review') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_rating') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_status') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_aksi') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recipes as $recipe)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-cream-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($recipe->image_url)<img loading="lazy" src="{{ $recipe->image_url }}" class="w-full h-full object-cover">@else<span class="text-lg">{{ $recipe->recipeable_type === 'drink' ? '🧋' : '🥘' }}</span>@endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="font-semibold text-gray-900 hover:text-walnut-500 transition line-clamp-1">{{ $recipe->getLocalizedTitle() }}</a>
                                    <p class="text-xs text-gray-400">{{ $recipe->created_at->isoFormat('D MMM Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-amber-100 rounded-full flex items-center justify-center text-xs font-bold text-amber-700">{{ strtoupper(substr($recipe->user->name, 0, 1)) }}</div>
                                <span class="text-gray-600">{{ $recipe->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center text-lg">{{ $recipe->recipeable_type === 'drink' ? '🧋' : '🥘' }}</td>
                        <td class="px-5 py-4 text-center font-medium text-gray-600">{{ $recipe->reviews_count }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 font-semibold"><span class="text-amber-400">★</span> {{ number_format($recipe->avg_rating, 1) }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="badge text-xs font-medium {{ $recipe->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $recipe->status }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('recipes.show', $recipe) }}" class="text-xs text-gray-400 hover:text-gray-600 px-2 py-1 rounded hover:bg-gray-100 transition" title="{{ __('ui.lihat') }}">👀</a>
                                <form method="POST" action="{{ route('admin.recipes.toggle-status', $recipe) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs px-2 py-1 rounded hover:bg-gray-100 transition {{ $recipe->status === 'published' ? 'text-amber-500 hover:text-amber-700' : 'text-green-500 hover:text-green-700' }}" title="{{ $recipe->status === 'published' ? __('ui.admin_jadikan_draft') : 'Publish' }}">
                                        {{ $recipe->status === 'published' ? '📋' : '📣' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}" onsubmit="return confirm('{{ __('ui.admin_hapus') }}: {{ $recipe->title }}?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-600 px-2 py-1 rounded hover:bg-red-50 transition" title="{{ __('ui.admin_hapus') }}">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-16 text-gray-400">{{ __('ui.admin_belum_ada_resep') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($recipes->hasPages())
        <div class="p-4 border-t border-gray-100 flex justify-center">{{ $recipes->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection

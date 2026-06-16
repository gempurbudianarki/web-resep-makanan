@extends('admin.layout')

@section('title', 'Manajemen Kategori - Admin')

@section('content')
<div class="flex items-center justify-between mb-6 slide-up">
    <h1 class="text-2xl font-display font-bold text-gray-900">{{ __('ui.admin_manajemen_kategori_title') }}</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
    <h2 class="font-bold text-gray-900 mb-4">{{ __('ui.admin_tambah_kategori') }}</h2>
    <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-3">
        @csrf
        <input type="text" name="name" required class="input-field flex-1" placeholder="{{ __('ui.admin_nama_kategori') }}">
        <button type="submit" class="btn-primary">{{ __('ui.admin_tambah_btn') }}</button>
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_nama_kategori') }}</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_slug') }}</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_jumlah_resep') }}</th>
                <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_aksi') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex items-center gap-3">
                            @csrf @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" required class="input-field !py-1.5 text-sm flex-1">
                            <button type="submit" class="text-amber-500 hover:text-amber-600 text-xs font-semibold flex-shrink-0">💾 {{ __('ui.admin_simpan') }}</button>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-xs font-mono">/{{ $category->slug }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="font-semibold text-gray-600">{{ $category->recipes_count }}</span>
                        <span class="text-gray-400 text-xs"> {{ __('ui.resep') }}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('{{ __('ui.admin_hapus') }} {{ $category->getLocalizedName() }}?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600 px-2 py-1 rounded hover:bg-red-50 transition font-medium">🗑 {{ __('ui.admin_hapus') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

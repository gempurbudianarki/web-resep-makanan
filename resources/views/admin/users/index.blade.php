@extends('admin.layout')

@section('title', 'Manajemen Pengguna - Admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 slide-up">
    <h1 class="text-2xl font-display font-bold text-gray-900">{{ __('ui.admin_manajemen_akun') }}</h1>
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('ui.admin_filter_cari') }}" class="input-field !py-2 !w-56 text-sm">
        <button type="submit" class="btn-primary text-sm">{{ __('ui.admin_filter_btn') }}</button>
    </form>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_pengguna') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_role') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_resep_count') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_review') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_status') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_bergabung') }}</th>
                    <th class="text-center px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">{{ __('ui.admin_tabel_aksi') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0 {{ $user->hasRole('superadmin') ? 'bg-purple-100 text-purple-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @foreach($user->roles as $role)
                                <span class="badge text-xs font-medium {{ $role->name === 'superadmin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.users.recipes', $user) }}" class="font-semibold text-amber-500 hover:text-amber-600">{{ $user->recipes_count }}</a>
                        </td>
                        <td class="px-5 py-4 text-center font-medium text-gray-600">{{ $user->reviews_count }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="badge text-xs font-medium {{ $user->banned_at ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">{{ $user->banned_at ? __('ui.admin_banned') : __('ui.admin_active') }}</span>
                        </td>
                        <td class="px-5 py-4 text-center text-xs text-gray-400">{{ $user->created_at->isoFormat('D MMM Y') }}</td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.users.recipes', $user) }}" class="text-xs text-gray-400 hover:text-gray-600 px-2 py-1 rounded hover:bg-gray-100 transition" title="Lihat resep">✍️</a>
                                @unless($user->hasRole('superadmin'))
                                    <form method="POST" action="{{ route('admin.users.toggle-ban', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs px-2 py-1 rounded hover:bg-gray-100 transition font-medium {{ $user->banned_at ? 'text-green-500 hover:text-green-700' : 'text-red-400 hover:text-red-600' }}" title="{{ $user->banned_at ? 'Unban' : 'Ban' }}">
                                            {{ $user->banned_at ? '🔓' : '🔒' }}
                                        </button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-16 text-gray-400">{{ __('ui.admin_belum_ada_user') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="p-4 border-t border-gray-100 flex justify-center">{{ $users->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection

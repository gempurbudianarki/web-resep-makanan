@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-display font-bold text-charcoal-500">{{ __('ui.profil_title') }}</h1>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    @if(session('success'))
        <div class="bg-olive-50 border border-olive-200 text-olive-600 px-5 py-3 rounded-xl text-sm flex items-center justify-between" x-data="{show:true}" x-show="show">
            <span>{{ session('success') }}</span><button @click="show=false" class="text-olive-400">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-2xl font-bold text-amber-600">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-charcoal-500">{{ auth()->user()->name }}</h2>
                <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
                <span class="badge bg-amber-100 text-amber-700 text-xs mt-1">{{ auth()->user()->roles->first()?->name ?? 'user' }}</span>
            </div>
        </div>

        <h3 class="font-semibold text-charcoal-500 mb-4">Informasi Akun</h3>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.nama_lengkap') }}</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="input-field">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.email') }}</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="input-field">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h3 class="font-semibold text-charcoal-500 mb-4">{{ __('ui.ganti_password') }}</h3>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.password_sekarang') }}</label>
                <input type="password" name="current_password" required class="input-field">
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.password_baru') }}</label>
                <input type="password" name="new_password" required class="input-field" placeholder="Minimal 8 karakter">
                @error('new_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.konfirmasi_password') }}</label>
                <input type="password" name="new_password_confirmation" required class="input-field">
            </div>
            <button type="submit" class="btn-primary">{{ __('ui.ganti_password') }}</button>
        </form>
    </div>
</div>
@endsection

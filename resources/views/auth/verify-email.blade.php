@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="max-w-lg mx-auto px-4 py-20">
    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 sm:p-10 text-center slide-up">
        <div class="w-20 h-20 bg-amber-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h2 class="text-2xl font-display font-bold text-charcoal-500 mb-3">{{ __('ui.verifikasi_email_title') }}</h2>
        <p class="text-gray-400 text-sm mb-2 leading-relaxed">
            {{ __('ui.verifikasi_email_desc') }} <span class="font-semibold text-charcoal-500">{{ auth()->user()->email }}</span>.
        </p>
        <p class="text-gray-400 text-sm mb-8 leading-relaxed">
            {{ __('ui.verifikasi_email_desc2') }}
        </p>

        @if(session('success'))
            <div class="bg-olive-50 border border-olive-200 text-olive-700 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col items-center gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary text-sm">
                    {{ __('ui.kirim_ulang') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-medium transition-colors duration-200 mt-2">
                    {{ __('ui.keluar') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

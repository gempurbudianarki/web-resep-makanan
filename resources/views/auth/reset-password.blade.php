<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password · BagiResep</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="google-site-verification" content="google93e40744dc34b1f1.html">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg { background: radial-gradient(ellipse at top, #8B6A4A 0%, #5A3E2E 40%, #2E1F14 100%); }
    </style>
</head>
<body class="min-h-screen auth-bg flex items-center justify-center p-4">
    <div class="w-full max-w-sm slide-up">
        <div class="bg-white rounded-3xl shadow-2xl p-6 lg:p-8">
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    <span class="text-lg font-display font-bold text-walnut-500">BagiResep</span>
                </a>
                <h2 class="text-xl font-display font-bold text-charcoal-500">{{ __('ui.reset_password_title') }}</h2>
                <p class="text-gray-400 text-xs mt-1">{{ __('ui.reset_password_desc') }}</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-3 py-2 rounded-xl mb-4 text-xs">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label class="block text-xs font-semibold text-charcoal-500 uppercase tracking-wider mb-1">{{ __('ui.email') }}</label>
                    <input type="email" value="{{ $email }}" disabled
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-cream-50 text-gray-400 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-charcoal-500 uppercase tracking-wider mb-1">{{ __('ui.password_baru_label') }}</label>
                    <input type="password" name="password" required autofocus
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-charcoal-500 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-300" placeholder="Min 8 karakter, huruf besar & angka">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-charcoal-500 uppercase tracking-wider mb-1">{{ __('ui.konfirmasi_password') }}</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-charcoal-500 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-300" placeholder="Ulangi password">
                </div>
                <button type="submit" class="w-full bg-amber-400 hover:bg-amber-500 text-white font-bold py-2.5 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98] mt-1">
                    {{ __('ui.reset_password_btn') }}
                </button>
            </form>
        </div>

        <a href="{{ route('home') }}" class="flex items-center justify-center gap-1.5 text-xs text-white/60 hover:text-white/90 mt-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('ui.kembali_beranda') }}
        </a>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · BagiResep</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="google-site-verification" content="google93e40744dc34b1f1.html">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        .auth-bg { background: radial-gradient(ellipse at top, #8B6A4A 0%, #5A3E2E 40%, #2E1F14 100%); }
    </style>
</head>
<body class="min-h-screen auth-bg flex">
    <div class="flex-1 hidden lg:flex items-center justify-center p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-64 h-64 bg-amber-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-amber-400 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 text-center max-w-md slide-up">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur rounded-2xl mb-8 border border-white/20">
                <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <h1 class="text-4xl font-display font-bold text-white mb-4">{{ __('ui.selamat_datang_kembali') }}</h1>
            <p class="text-cream-300/70 leading-relaxed">{{ __('ui.masuk_deskripsi') }}</p>
        </div>
    </div>

    <div class="w-full lg:w-[480px] flex items-center justify-center p-6">
        <div class="w-full max-w-sm slide-up" style="animation-delay: 0.1s">
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        <span class="text-xl font-display font-bold text-walnut-500">BagiResep</span>
                    </a>
                    <h2 class="text-2xl font-display font-bold text-charcoal-500">{{ __('ui.masuk') }}</h2>
                    <p class="text-gray-400 text-sm mt-1">{{ __('ui.lanjutkan_perjalanan') }}</p>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-charcoal-500 uppercase tracking-wider mb-1.5">{{ __('ui.email') }}</label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-charcoal-500 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-300" placeholder="nama@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal-500 uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <input :type="show ? 'text' : 'password'" name="password" required class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl text-sm text-charcoal-500 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-300" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-amber-400 focus:ring-amber-400 transition">
                            <span class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('ui.ingat_saya') }}</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs text-amber-500 hover:text-amber-600 font-medium transition-colors">{{ __('ui.lupa_password') }}</a>
                    </div>
                    <div class="flex items-center justify-center">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-size="normal" data-theme="light"></div>
                    </div>
                    <button type="submit" class="w-full bg-amber-400 hover:bg-amber-500 text-white font-bold py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98]">
                        {{ __('ui.masuk') }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">{{ __('ui.belum_punya_akun') }} <a href="{{ route('register') }}" class="text-amber-500 hover:text-amber-600 font-semibold transition-colors">{{ __('ui.daftar_sekarang') }}</a></p>
                </div>
            </div>

            <a href="{{ route('home') }}" class="flex items-center justify-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 mt-6 transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('ui.kembali_beranda') }}
            </a>
        </div>
    </div>
</body>
</html>

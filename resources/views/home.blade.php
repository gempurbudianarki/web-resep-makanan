<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <title>BagiResep · Temukan & Bagikan Resep Favoritmu</title>
    <meta name="description" content="Platform berbagi resep masakan Indonesia. Temukan, simpan, dan bagikan resep favoritmu bersama komunitas kuliner terbesar.">
    <meta name="keywords" content="resep masakan, resep indonesia, masakan rumahan, kuliner, bagi resep, resep kue, resep tradisional">
    <link rel="canonical" href="{{ url('/') }}">

    <meta property="og:site_name" content="BagiResep">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="BagiResep · Temukan & Bagikan Resep Favoritmu">
    <meta property="og:description" content="Platform berbagi resep masakan Indonesia. Temukan, simpan, dan bagikan resep favoritmu bersama komunitas.">
    <meta property="og:image" content="{{ asset('storage/sampul/sampuldepan.webp') }}">
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BagiResep · Temukan & Bagikan Resep Favoritmu">
    <meta name="twitter:description" content="Platform berbagi resep masakan Indonesia. Temukan, simpan, dan bagikan resep favoritmu.">
    <meta name="twitter:image" content="{{ asset('storage/sampul/sampuldepan.webp') }}">

    <meta name="google-site-verification" content="google93e40744dc34b1f1.html">

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        .hero-bg {
            background: url('{{ asset('storage/sampul/sampuldepan.webp') }}') center/cover no-repeat;
        }
        .desktop-links { display: flex; }
        .mobile-menu-button { display: none; }
        .glass-panel {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.12);
        }

        @media (max-width: 639px) {
            .desktop-links { display: none !important; }
            .mobile-menu-button { display: inline-flex !important; }
        }

        @keyframes menuSlideIn {
            from { opacity: 0; transform: translateY(-8px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes menuSlideOut {
            from { opacity: 1; transform: translateY(0) scale(1); }
            to { opacity: 0; transform: translateY(-8px) scale(0.96); }
        }
        .menu-enter { animation: menuSlideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .menu-exit { animation: menuSlideOut 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="min-h-screen">
    <div class="hero-bg relative min-h-screen flex flex-col">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/15 to-black/60"></div>

        <div class="relative z-10 flex justify-end items-center gap-4 px-6 py-6">
            <div class="desktop-links items-center gap-4">
                <a href="{{ route('login') }}" class="text-white/70 hover:text-white text-sm font-medium tracking-wide transition-all duration-300 hover:-translate-y-0.5">{{ __('ui.masuk') }}</a>
                <a href="{{ route('register') }}" class="bg-amber-400 hover:bg-amber-300 text-walnut-800 text-sm px-7 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-amber-500/30 hover:-translate-y-0.5 active:scale-95">{{ __('ui.daftar_gratis') }}</a>
            </div>
            <button id="mobile-menu-button" class="mobile-menu-button inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-white/20 bg-white/10 text-white shadow-lg backdrop-blur-md hover:bg-white/20 hover:border-white/30 transition-all duration-300 active:scale-95" aria-label="Buka menu">
                <span data-open class="text-xl leading-none transition-transform duration-300">≡</span>
                <span data-closed class="hidden text-xl leading-none transition-transform duration-300">×</span>
            </button>
        </div>
        <div id="mobile-menu-panel" class="mobile-menu-panel hidden relative z-20 mx-4 mb-4 rounded-3xl p-5 shadow-2xl shadow-black/30 glass-panel">
            <a href="{{ route('login') }}" class="block rounded-2xl bg-white/10 backdrop-blur-sm border border-white/10 px-4 py-3.5 text-center text-sm font-medium text-white hover:bg-white/20 hover:border-white/20 transition-all duration-300 active:scale-[0.98]">{{ __('ui.masuk') }}</a>
            <a href="{{ route('register') }}" class="mt-3 block rounded-2xl bg-amber-400 px-4 py-3.5 text-center text-sm font-bold text-walnut-900 hover:bg-amber-300 active:scale-[0.98] transition-all duration-300 shadow-lg shadow-amber-500/20">{{ __('ui.daftar_gratis') }}</a>
        </div>

        <div class="relative z-10 flex-1 flex items-center justify-center px-6 pb-24">
            <div class="text-center max-w-2xl slide-up">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur rounded-2xl mb-8 border border-white/20">
                    <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-display font-extrabold text-white leading-none drop-shadow-2xl tracking-[-0.02em]">BagiResep</h1>
                <p class="text-base md:text-lg text-white/75 mt-6 font-light tracking-widest uppercase">{{ __('ui.temukan_bagikan_resep') }}</p>
                <div class="mt-12">
                    <a href="{{ route('recipes.index') }}" class="inline-flex items-center gap-3 bg-amber-400 hover:bg-amber-300 text-walnut-800 text-base px-10 py-4 rounded-xl font-bold transition-all duration-300 shadow-2xl hover:shadow-amber-500/40 hover:-translate-y-0.5 active:scale-95">
                        {{ __('ui.jelajahi_resep_btn') }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var button = document.getElementById('mobile-menu-button');
            var panel = document.getElementById('mobile-menu-panel');
            var openIcon = document.querySelector('[data-open]');
            var closedIcon = document.querySelector('[data-closed]');

            if (!button || !panel) return;

            button.addEventListener('click', function () {
                var isHidden = panel.classList.contains('hidden');

                if (isHidden) {
                    panel.classList.remove('hidden', 'menu-exit');
                    panel.classList.add('menu-enter');
                    openIcon.classList.add('hidden');
                    closedIcon.classList.remove('hidden');
                    button.classList.add('!bg-white/20', '!border-white/30');
                } else {
                    panel.classList.remove('menu-enter');
                    panel.classList.add('menu-exit');
                    openIcon.classList.remove('hidden');
                    closedIcon.classList.add('hidden');
                    button.classList.remove('!bg-white/20', '!border-white/30');
                    setTimeout(function () {
                        panel.classList.add('hidden');
                        panel.classList.remove('menu-exit');
                    }, 200);
                }
            });
        });
    </script>
</body>
</html>

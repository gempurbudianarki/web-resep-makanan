<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow, max-image-preview:large">

    <title>@yield('title', 'BagiResep') · Platform Berbagi Resep Indonesia</title>
    <meta name="description" content="@yield('meta_description', 'Platform berbagi resep masakan Indonesia. Temukan, simpan, dan bagikan resep favoritmu bersama komunitas.')">
    <meta name="keywords" content="@yield('meta_keywords', 'resep masakan, resep indonesia, masakan rumahan, resep kue, masakan tradisional, kuliner, resep minuman, bagi resep')">
    <meta name="author" content="BagiResep">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <meta property="og:site_name" content="BagiResep">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('title', 'BagiResep') · Platform Berbagi Resep Indonesia">
    <meta property="og:description" content="@yield('meta_description', 'Platform berbagi resep masakan Indonesia.')">
    <meta property="og:image" content="@yield('og_image', asset('storage/sampul/sampuldepan.webp'))">
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'BagiResep') · Platform Berbagi Resep Indonesia">
    <meta name="twitter:description" content="@yield('meta_description', 'Platform berbagi resep masakan Indonesia.')">
    <meta name="twitter:image" content="@yield('og_image', asset('storage/sampul/sampuldepan.webp'))">

    <meta name="google-site-verification" content="google93e40744dc34b1f1.html">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen flex flex-col">
    <div id="page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-gradient-to-br from-walnut-800 via-walnut-700 to-walnut-900 transition-opacity duration-500">
        <div class="flex flex-col items-center gap-6 scale-in">
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 rounded-full border-4 border-amber-400/20"></div>
                <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-amber-400 animate-spin"></div>
                <div class="absolute inset-2 rounded-full bg-walnut-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-display font-bold text-amber-400 text-center tracking-tight">BagiResep</h2>
                <p class="text-cream-300/50 text-xs text-center mt-1 tracking-wide">Memuat resep terbaik...</p>
            </div>
            <div class="flex gap-1.5">
                <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0s"></div>
                <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0.15s"></div>
                <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0.3s"></div>
            </div>
        </div>
    </div>
    <nav class="bg-walnut-700/95 backdrop-blur-md border-b border-white/5 sticky top-0 z-50 shadow-xl shadow-black/20" x-data="{ open: false, userMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex items-center h-14">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 z-10 group">
                    <svg class="w-6 h-6 text-amber-400 transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="text-lg font-display font-bold text-amber-400 tracking-tight transition-colors duration-300 group-hover:text-amber-300">BagiResep</span>
                </a>

                <div class="hidden md:flex items-center gap-0.5 absolute inset-x-0 justify-center pointer-events-none">
                    <a href="{{ route('home') }}" class="pointer-events-auto relative px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('home') ? 'text-amber-400 bg-white/10' : 'text-cream-100/70 hover:text-white hover:bg-white/5' }}">
                        {{ __('ui.beranda') }}
                        @if(request()->routeIs('home'))<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-amber-400 rounded-full"></span>@endif
                    </a>
                    <a href="{{ route('recipes.index') }}" class="pointer-events-auto relative px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('recipes.*') && !request()->routeIs('recipes.create') ? 'text-amber-400 bg-white/10' : 'text-cream-100/70 hover:text-white hover:bg-white/5' }}">
                        {{ __('ui.jelajahi') }}
                        @if(request()->routeIs('recipes.*') && !request()->routeIs('recipes.create'))<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-amber-400 rounded-full"></span>@endif
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-2 ml-auto z-10">
                    <form action="{{ route('recipes.index') }}" method="GET" class="relative group">
                        <input type="text" name="search" placeholder="Cari resep..."
                               class="bg-white/5 border border-white/10 text-cream-100 text-xs rounded-xl pl-9 pr-3 py-2 w-36 focus:w-56 transition-all duration-500 ease-out focus:outline-none focus:border-amber-400/40 focus:bg-white/10 placeholder-cream-400/40">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-cream-400/50 text-xs transition-colors duration-300 group-hover:text-amber-400/70">🔎</span>
                    </form>

                    <a href="{{ request()->fullUrlWithQuery(['lang' => app()->getLocale() === 'id' ? 'en' : 'id']) }}" class="text-cream-100/50 hover:text-cream-100 text-xs font-bold transition-colors duration-300 px-2 py-2 border border-white/10 rounded-lg hover:border-white/20" title="{{ app()->getLocale() === 'id' ? 'Switch to English' : 'Ganti ke Indonesia' }}">
                        {{ app()->getLocale() === 'id' ? '🇬🇧 EN' : '🇮🇩 ID' }}
                    </a>
                    @auth
                        <a href="{{ route('recipes.create') }}" class="flex items-center gap-1.5 bg-amber-400 hover:bg-amber-300 text-walnut-800 text-xs font-bold px-4 py-2 rounded-xl transition-all duration-300 shadow-md hover:shadow-amber-400/30 hover:-translate-y-0.5 active:scale-95">
                            <span class="text-base leading-none">+</span> {{ __('ui.buat_resep') }}
                        </a>
                        <div class="relative" @click.away="userMenu = false">
                            <button @click="userMenu = !userMenu" class="flex items-center gap-1.5 text-cream-100/80 hover:text-white transition-colors duration-300 pl-2 ml-1 border-l border-white/10 group">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center text-xs font-bold text-white shadow-md group-hover:shadow-amber-400/30 transition-shadow duration-300">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                <svg class="w-3 h-3 text-cream-400 transition-transform duration-300" :class="{'rotate-180': userMenu}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="userMenu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 -translate-y-2 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl shadow-black/20 border border-gray-100 overflow-hidden z-50">
                                <div class="px-5 py-4 bg-cream-50 border-b border-gray-100">
                                    <p class="font-bold text-charcoal-500 text-sm">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ auth()->user()->email }}</p>
                                    @if(auth()->user()->hasPermissionTo('bypass-all'))
                                        <span class="inline-block mt-2 badge bg-purple-100 text-purple-700 text-xs font-semibold">{{ __('ui.superadmin') }}</span>
                                    @endif
                                </div>
                                <div class="py-1.5">
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-charcoal-500 hover:bg-cream-50 transition-colors duration-200 font-medium">
                                        <span class="w-5 text-center text-base">✍️</span> {{ __('ui.resep_saya') }}
                                    </a>
                                    <a href="{{ route('bookmarks.index') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-charcoal-500 hover:bg-cream-50 transition-colors duration-200 font-medium">
                                        <span class="w-5 text-center text-base">📑</span> {{ __('ui.bookmark') }}
                                    </a>
                                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-charcoal-500 hover:bg-cream-50 transition-colors duration-200 font-medium">
                                        <span class="w-5 text-center text-base">🧑</span> {{ __('ui.profil') }}
                                    </a>
                                    @if(auth()->user()->hasPermissionTo('bypass-all'))
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm text-purple-600 hover:bg-purple-50 transition-colors duration-200 font-semibold">
                                            <span class="w-5 text-center text-base">⚡</span> {{ __('ui.admin_panel') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="border-t border-gray-100 py-1.5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-5 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors duration-200 font-medium">
                                            <span class="w-5 text-center text-base">🚶</span> {{ __('ui.keluar') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-cream-100/70 hover:text-white text-sm font-medium transition-colors duration-300 px-3 py-2">{{ __('ui.masuk') }}</a>
                        <a href="{{ route('register') }}" class="bg-amber-400 hover:bg-amber-300 text-walnut-800 text-sm font-bold px-5 py-2 rounded-xl transition-all duration-300 shadow-md hover:shadow-amber-400/30 hover:-translate-y-0.5 active:scale-95">{{ __('ui.daftar') }}</a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center gap-2 ml-auto z-10">
                    @auth
                        <a href="{{ route('recipes.create') }}" class="bg-amber-400 text-walnut-800 text-xs px-3 py-1.5 rounded-lg font-bold">+</a>
                    @endauth
                    <button @click="open = !open" class="text-cream-100 p-1.5 rounded-lg hover:bg-white/10 transition-colors duration-300" aria-label="Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'block': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !open, 'block': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden border-t border-white/5 bg-walnut-700/95 backdrop-blur-md" @click.away="open = false">
            <div class="px-4 py-5 space-y-1">
                <form action="{{ route('recipes.index') }}" method="GET" class="mb-3">
                    <input type="text" name="search" placeholder="Cari resep..." class="w-full bg-white/5 border border-white/10 text-cream-100 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-400/40 placeholder-cream-400/40">
                </form>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">🏡 {{ __('ui.beranda') }}</a>
                <a href="{{ route('recipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">🔎 {{ __('ui.jelajahi') }}</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">✍️ {{ __('ui.resep_saya') }}</a>
                    <a href="{{ route('bookmarks.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">📑 {{ __('ui.bookmark') }}</a>
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">🧑 {{ __('ui.profil') }}</a>
                    @if(auth()->user()->hasPermissionTo('bypass-all'))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-purple-300 text-sm font-medium rounded-xl hover:bg-purple-500/10 transition-colors duration-200">⚡ {{ __('ui.admin_panel') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-red-300 text-sm font-medium rounded-xl hover:bg-red-500/10 transition-colors duration-200">🚶 {{ __('ui.keluar') }}</button>
                    </form>
                @else
                    <div class="flex gap-2 mt-3 px-3">
                        <a href="{{ route('login') }}" class="flex-1 text-center border border-white/20 text-cream-100 text-sm font-medium py-2.5 rounded-xl hover:bg-white/5 transition-colors duration-200">{{ __('ui.masuk') }}</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-amber-400 text-walnut-800 text-sm font-bold py-2.5 rounded-xl hover:bg-amber-300 transition-all duration-300">{{ __('ui.daftar') }}</a>
                    </div>
                @endauth
                <a href="{{ request()->fullUrlWithQuery(['lang' => app()->getLocale() === 'id' ? 'en' : 'id']) }}" class="flex items-center gap-3 px-3 py-2.5 text-cream-100/60 text-sm font-medium rounded-xl hover:bg-white/5 transition-colors duration-200">
                    {{ app()->getLocale() === 'id' ? '🇬🇧 English' : '🇮🇩 Indonesia' }}
                </a>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="bg-olive-50 border-b border-olive-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <span class="text-olive-600 text-sm">{{ session('success') }}</span>
                <button @click="show = false" class="text-olive-400 hover:text-olive-600">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="bg-red-50 border-b border-red-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <span class="text-red-600 text-sm">{{ session('error') }}</span>
                <button @click="show = false" class="text-red-400 hover:text-red-600">&times;</button>
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-walnut-800 text-cream-300 mt-10 sm:mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-10 py-10 sm:py-16">
                <div class="sm:col-span-2 lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-5">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        <span class="text-xl font-display font-bold text-amber-400">BagiResep</span>
                    </a>
                    <p class="text-sm text-cream-400 leading-relaxed mb-5">
                        {{ __('ui.footer_desc') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 bg-walnut-700 hover:bg-amber-400 rounded-lg flex items-center justify-center text-cream-200 hover:text-white transition-all text-sm" title="Instagram">📸</a>
                        <a href="#" class="w-9 h-9 bg-walnut-700 hover:bg-amber-400 rounded-lg flex items-center justify-center text-cream-200 hover:text-white transition-all text-sm" title="YouTube">▶️</a>
                        <a href="#" class="w-9 h-9 bg-walnut-700 hover:bg-amber-400 rounded-lg flex items-center justify-center text-cream-200 hover:text-white transition-all text-sm" title="Facebook">📖</a>
                        <a href="#" class="w-9 h-9 bg-walnut-700 hover:bg-amber-400 rounded-lg flex items-center justify-center text-cream-200 hover:text-white transition-all text-sm" title="Twitter">✧</a>
                    </div>
                </div>

            </div>

            <div class="border-t border-walnut-700 py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="space-y-2 text-xs text-cream-500">
                    <p>&copy; {{ date('Y') }} <span class="text-amber-400 font-semibold">BagiResep</span>. {{ __('ui.hak_cipta') }}</p>
                    <p>Kontak WA: <a href="https://wa.me/6285600841078" class="text-amber-400 hover:text-amber-300 transition">085600841078</a></p>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-cream-500">
                    <a href="{{ route('privacy') }}" class="hover:text-amber-400 transition">{{ __('ui.kebijakan_privasi') }}</a>
                    <span class="text-walnut-600">|</span>
                    <a href="{{ route('terms') }}" class="hover:text-amber-400 transition">{{ __('ui.syarat_penggunaan') }}</a>
                    <span class="text-walnut-600">|</span>
                    <a href="https://wa.me/6285600841078" class="hover:text-amber-400 transition">{{ __('ui.kontak') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        if (entry.target.classList.contains('stagger')) {
                            var children = entry.target.children;
                            for (var i = 0; i < children.length; i++) {
                                children[i].style.animationDelay = (i * 0.08) + 's';
                            }
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal-on-scroll').forEach(function(el) {
                observer.observe(el);
            });
        })();
    </script>

    <script>
        (function() {
            var loader = document.getElementById('page-loader');
            if (!loader) return;
            var hide = function() {
                loader.style.opacity = '0';
                setTimeout(function() { loader.style.display = 'none'; }, 500);
            };
            window.addEventListener('load', hide);
            setTimeout(hide, 3000);
        })();
    </script>

    @stack('scripts')

    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 z-[9998] transition-all duration-500" style="display:none">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4 sm:pb-6">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4 animate-float-up">
                <div class="flex items-start gap-3 flex-1 min-w-0">
                    <span class="text-2xl sm:text-3xl flex-shrink-0 mt-0.5">🍪</span>
                    <div class="text-sm text-gray-500 leading-relaxed">
                        <p class="text-charcoal-500 font-semibold mb-1">Situs ini menggunakan cookie</p>
                        <p>Kami menggunakan cookie sesi yang diperlukan agar website berfungsi dengan baik - seperti menjaga Anda tetap login dan melindungi dari serangan. Kami <strong class="text-charcoal-500">tidak</strong> menggunakan cookie pelacakan, cookie iklan, atau cookie pihak ketiga. Dengan melanjutkan, Anda menyetujui penggunaan cookie esensial ini.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0 sm:flex-col sm:items-stretch">
                    <button onclick="acceptCookies()" class="btn-primary text-sm px-6 py-2.5 whitespace-nowrap">Setuju</button>
                    <a href="{{ route('privacy') }}" class="text-xs text-gray-400 hover:text-amber-500 transition-colors text-center py-1.5">Kebijakan Privasi →</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var banner = document.getElementById('cookie-banner');
            if (!banner || localStorage.getItem('cookie_consent')) return;
            banner.style.display = 'block';
        })();
        function acceptCookies() {
            localStorage.setItem('cookie_consent', '1');
            var banner = document.getElementById('cookie-banner');
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(20px)';
            setTimeout(function() { banner.style.display = 'none'; }, 500);
        }
    </script>
</body>
</html>

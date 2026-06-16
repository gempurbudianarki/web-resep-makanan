<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · BagiResep</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-cream min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <aside class="hidden md:flex md:flex-col w-64 bg-walnut-700 text-cream-200">
            <div class="p-6 border-b border-walnut-600">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="text-xl">🔥</span>
                    <span class="text-lg font-display font-bold text-amber-400">BagiResep</span>
                </a>
                <div class="flex items-center gap-2 mt-2">
                    <span class="inline-flex items-center gap-1.5 bg-purple-500/15 border border-purple-500/20 text-purple-300 text-xs font-bold px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse"></span> {{ __('ui.superadmin') }}
                    </span>
                </div>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <p class="text-xs text-cream-400 uppercase tracking-wider font-semibold px-3 mb-3 mt-2">{{ __('ui.admin_menu_utama') }}</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-walnut-600 text-white shadow-sm' : 'text-cream-300 hover:bg-walnut-600/50 hover:text-white' }}">
                    <span class="text-lg">📈</span> {{ __('ui.beranda') }}
                </a>
                <a href="{{ route('admin.recipes') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.recipes*') ? 'bg-walnut-600 text-white shadow-sm' : 'text-cream-300 hover:bg-walnut-600/50 hover:text-white' }}">
                    <span class="text-lg">✍️</span> {{ __('ui.semua_resep') }}
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users*') ? 'bg-walnut-600 text-white shadow-sm' : 'text-cream-300 hover:bg-walnut-600/50 hover:text-white' }}">
                    <span class="text-lg">👥</span> {{ __('ui.pengguna') }}
                </a>
                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.categories*') ? 'bg-walnut-600 text-white shadow-sm' : 'text-cream-300 hover:bg-walnut-600/50 hover:text-white' }}">
                    <span class="text-lg">🏷</span> {{ __('ui.kategori') }}
                </a>
                <div class="border-t border-walnut-600 my-4"></div>
                <p class="text-xs text-cream-400 uppercase tracking-wider font-semibold px-3 mb-3">{{ __('ui.admin_lainnya') }}</p>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-cream-300 hover:bg-walnut-600/50 hover:text-white transition-all">
                    <span class="text-lg">🏡</span> {{ __('ui.admin_ke_website') }}
                </a>
                <a href="{{ route('recipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-cream-300 hover:bg-walnut-600/50 hover:text-white transition-all">
                    <span class="text-lg">🔎</span> {{ __('ui.admin_jelajahi_resep') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all w-full text-left mt-2">
                        <span class="text-lg">🚶</span> {{ __('ui.admin_logout') }}
                    </button>
                </form>
            </nav>
        </aside>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="md:hidden bg-walnut-500 border-b border-walnut-400 px-4 py-3 flex items-center justify-between">
                <span class="font-display font-bold text-amber-400">BagiResep Admin</span>
                <a href="{{ route('home') }}" class="text-cream-200 text-sm">Website</a>
            </header>
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         class="bg-olive-50 border border-olive-200 text-olive-700 px-5 py-3.5 rounded-2xl mb-6 text-sm flex items-center justify-between shadow-sm fade-in">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-olive-400 hover:text-olive-600 text-lg leading-none">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl mb-6 text-sm shadow-sm fade-in">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

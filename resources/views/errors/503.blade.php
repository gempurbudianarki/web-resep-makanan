<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sedang Maintenance · BagiResep</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        body { background: linear-gradient(180deg, #1a0f0a 0%, #2d1f14 50%, #1a0f0a 100%); }
        .pulse-ring { animation: pulseRing 2s ease-out infinite; }
        @keyframes pulseRing {
            0% { transform: scale(0.9); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.2; }
            100% { transform: scale(0.9); opacity: 0.5; }
        }
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spin-slow { animation: spinSlow 20s linear infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="text-center max-w-md">
        <div class="relative w-28 h-28 mx-auto mb-8">
            <div class="absolute inset-0 rounded-full border-2 border-amber-400/20 pulse-ring"></div>
            <div class="absolute inset-2 rounded-full border border-amber-400/10 spin-slow" style="border-style: dashed;"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-xl shadow-amber-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                </div>
            </div>
        </div>

        <h1 class="text-2xl font-display font-bold text-white mb-2">Sedang Maintenance</h1>
        <p class="text-cream-300/60 text-sm leading-relaxed mb-2">Kami sedang melakukan pembaruan sistem untuk memberikan pengalaman yang lebih baik.</p>
        <p class="text-cream-400/30 text-xs">Silakan kembali dalam beberapa menit.</p>

        <div class="mt-10 flex items-center justify-center gap-2">
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0s"></div>
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0.2s"></div>
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-bounce" style="animation-delay:0.4s"></div>
        </div>

        <p class="text-cream-400/20 text-xs mt-12">&copy; {{ date('Y') }} BagiResep</p>
    </div>
</body>
</html>

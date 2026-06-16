<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>429 - Terlalu Banyak · BagiResep</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-cream flex items-center justify-center p-6">
    <div class="text-center max-w-md slide-up">
        <div class="w-20 h-20 bg-amber-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-4xl font-display font-bold text-charcoal-500 mb-3">429</h1>
        <p class="text-gray-500 mb-2 text-lg">Terlalu Banyak Permintaan</p>
        <p class="text-gray-400 text-sm mb-8">Kamu mengirim terlalu banyak permintaan. Silakan tunggu beberapa saat dan coba lagi.</p>
        <a href="{{ route('home') }}" class="btn-primary text-sm">Ke Beranda</a>
    </div>
</body>
</html>

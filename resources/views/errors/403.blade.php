<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak · BagiResep</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|playfair-display:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-cream flex items-center justify-center p-6">
    <div class="text-center max-w-md slide-up">
        <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="text-4xl font-display font-bold text-charcoal-500 mb-3">403</h1>
        <p class="text-gray-500 mb-2 text-lg">Akses Ditolak</p>
        <p class="text-gray-400 text-sm mb-8">Kamu tidak memiliki izin untuk mengakses halaman ini.</p>
        <div class="flex gap-3 justify-center">
            <a href="javascript:history.back()" class="btn-secondary text-sm">← Kembali</a>
            <a href="{{ route('home') }}" class="btn-primary text-sm">Ke Beranda</a>
        </div>
    </div>
</body>
</html>

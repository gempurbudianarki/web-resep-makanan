<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $recipe->title }} · BagiResep</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            @page { margin: 1.5cm; size: A4; }
            body { font-size: 11pt; color: #1a1a1a; line-height: 1.7; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
        body { font-family: 'Georgia', 'Times New Roman', serif; background: #fff; color: #2E2E2E; }
    </style>
</head>
<body class="max-w-3xl mx-auto p-6 md:p-10">
    <div class="no-print fixed top-4 right-4 z-50 flex gap-2">
        <button onclick="window.print()" class="bg-amber-400 hover:bg-amber-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-lg transition flex items-center gap-2">
            🖨️ Cetak Resep
        </button>
        <a href="{{ route('recipes.show', $recipe) }}" class="bg-white hover:bg-gray-50 text-gray-600 px-5 py-2.5 rounded-xl font-medium text-sm shadow border border-gray-200 transition">
            ← Kembali
        </a>
    </div>

    <header class="text-center mb-8 pb-6 border-b-2 border-amber-400">
        <h1 class="text-3xl md:text-4xl font-bold mb-3" style="font-family: 'Playfair Display', Georgia, serif;">{{ $recipe->getLocalizedTitle() }}</h1>
        <div class="text-gray-500 text-sm space-x-4">
            <span>👤 {{ $recipe->user->name }}</span>
            <span>📅 {{ $recipe->created_at->isoFormat('D MMMM Y') }}</span>
            <span>⭐ {{ number_format($recipe->avg_rating, 1) }}</span>
        </div>
        @if($recipe->recipeable && method_exists($recipe->recipeable, 'getRecipeDetails'))
            <div class="flex flex-wrap justify-center gap-2 mt-4">
                @foreach(explode(' | ', $recipe->recipeable->getRecipeDetails()) as $detail)
                    <span class="text-xs bg-gray-100 px-3 py-1 rounded-full">{{ $detail }}</span>
                @endforeach
            </div>
        @endif
    </header>

    @if($recipe->image_url)
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="w-full h-56 object-cover rounded-xl mb-8">
    @endif

    <div class="text-lg leading-relaxed mb-8 text-gray-700 italic border-l-4 border-amber-300 pl-5">
        {{ $recipe->getLocalizedDescription() }}
    </div>

    @if($recipe->ingredients->count())
        <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">🧂 {{ __('ui.bahan_bahan') }}</h2>
        <div class="grid grid-cols-2 gap-x-8 gap-y-2 mb-8">
            @foreach($recipe->ingredients as $ingredient)
                <div class="flex justify-between py-1.5 border-b border-gray-100">
                    <span>{{ $ingredient->getLocalizedName() }}</span>
                    <span class="text-gray-500">{{ $ingredient->pivot->amount }} {{ $ingredient->pivot->unit }}</span>
                </div>
            @endforeach
        </div>
    @endif

    @php $localizedSteps = $recipe->getLocalizedSteps(); @endphp
    @if($localizedSteps)
        <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">📋 {{ __('ui.langkah_langkah') }}</h2>
        <ol class="space-y-4 mb-8">
            @foreach($localizedSteps as $i => $step)
                <li class="flex gap-4">
                    <span class="flex-shrink-0 w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold text-sm">{{ $i + 1 }}</span>
                    <p class="pt-1">{{ $step }}</p>
                </li>
            @endforeach
        </ol>
    @endif

    <footer class="mt-12 pt-6 border-t border-gray-200 text-center text-xs text-gray-400">
        <p>Dicetak dari <strong>BagiResep</strong> - {{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        <p class="mt-1">{{ route('recipes.show', $recipe) }}</p>
    </footer>
</body>
</html>

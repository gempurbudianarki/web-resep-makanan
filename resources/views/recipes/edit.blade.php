@extends('layouts.app')

@section('title', 'Edit: ' . $recipe->title)

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-display font-bold text-charcoal-500">{{ __('ui.edit_resep_title') }}</h1>
        <p class="text-gray-400 mt-1">{{ $recipe->getLocalizedTitle() }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 text-sm space-y-1">
            <p class="font-semibold mb-2">{{ __('ui.error_perbaiki') }}</p>
            @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-6 relative" id="recipe-form" onsubmit="document.getElementById('submit-overlay').style.display='flex'; return true;">
        @csrf @method('PUT')

        <div id="submit-overlay" class="absolute inset-0 z-50 flex-col items-center justify-center bg-white/95 backdrop-blur-sm rounded-2xl" style="display:none">
            <div class="flex flex-col items-center gap-6">
                <div class="relative">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 flex items-center justify-center shadow-xl shadow-amber-500/30">
                        <svg class="w-10 h-10 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-lg font-display font-bold text-charcoal-500">Menyimpan perubahan...</p>
                    <p class="text-gray-400 text-sm mt-1">Resep sedang diperbarui ✨</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">📃</span> {{ __('ui.informasi_resep') }}</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">Gambar Sampul</label>
                    <div class="flex items-start gap-5">
                        <img id="cover-preview" src="{{ $recipe->image_url ?? 'https://placehold.co/400x250/F8F4EE/9ca3af?text=No+Image' }}" class="w-40 h-28 object-cover rounded-xl border-2 border-dashed border-gray-200 flex-shrink-0">
                        <div class="flex-1">
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="input-field" onchange="previewImage(event)">
                            @if($recipe->image)
                                <label class="flex items-center gap-2 mt-2 text-sm text-red-500 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded"> {{ __('ui.hapus_gambar_checkbox') }}
                                </label>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.judul_resep') }}</label>
                    <input type="text" name="title" value="{{ old('title', $recipe->title) }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.deskripsi') }}</label>
                    <textarea name="description" rows="3" class="input-field">{{ old('description', $recipe->description) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">Status</label>
                    <select name="status" class="input-field">
                        <option value="published" {{ old('status', $recipe->status) === 'published' ? 'selected' : '' }}>📣 Published</option>
                        <option value="draft" {{ old('status', $recipe->status) === 'draft' ? 'selected' : '' }}>✍️ Draft</option>
                    </select>
                </div>
            </div>
        </div>

        @if($recipe->recipeable_type === 'food')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6">🥘 {{ __('ui.detail_makanan') }}</h2>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.waktu_masak') }}</label><input type="number" name="recipeable[cooking_time]" min="0" value="{{ old('recipeable.cooking_time', $recipe->recipeable->cooking_time ?? 0) }}" class="input-field"></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.porsi') }}</label><input type="number" name="recipeable[serving_size]" min="1" value="{{ old('recipeable.serving_size', $recipe->recipeable->serving_size ?? 1) }}" class="input-field"></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.kalori') }}</label><input type="number" name="recipeable[calories]" min="0" value="{{ old('recipeable.calories', $recipe->recipeable->calories ?? 0) }}" class="input-field"></div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6">🧋 {{ __('ui.detail_minuman') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.suhu') }}</label><select name="recipeable[is_cold]" class="input-field"><option value="1" {{ old('recipeable.is_cold', $recipe->recipeable->is_cold ?? true) == '1' ? 'selected' : '' }}>🧊 {{ __('ui.dingin') }}</option><option value="0" {{ old('recipeable.is_cold') == '0' ? 'selected' : '' }}>☕ {{ __('ui.panas') }}</option></select></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.tipe_gelas') }}</label><input type="text" name="recipeable[glass_type]" value="{{ old('recipeable.glass_type', $recipe->recipeable->glass_type ?? '') }}" class="input-field"></div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6">🏷 {{ __('ui.kategori_label') }}</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $cat)
                    <label class="flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border transition-all {{ in_array($cat->id, old('categories', $recipe->categories->pluck('id')->toArray())) ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', $recipe->categories->pluck('id')->toArray())) ? 'checked' : '' }} class="text-amber-400 focus:ring-amber-400 rounded">
                        <span class="text-sm font-medium text-charcoal-500">{{ $cat->getLocalizedName() }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8" x-data="ingredientManager({{ $recipe->ingredients->count() }})">
            <div class="flex items-center justify-between mb-6"><h2 class="text-lg font-bold text-charcoal-500">🧄 {{ __('ui.bahan_label') }}</h2><button type="button" @click="add()" class="text-amber-500 hover:text-amber-600 text-sm font-semibold">+ {{ __('ui.tambah_bahan') }}</button></div>
            <datalist id="ingredients-list-edit">
                @foreach($ingredients as $ing)
                    <option value="{{ $ing->name }}">{{ $ing->name }}</option>
                @endforeach
            </datalist>
            <div class="space-y-3">
                <template x-for="(item, idx) in items" :key="idx">
                    <div class="flex gap-3 items-end">
                        <div class="flex-1">
                            <input type="text" :name="'ingredients['+idx+'][ingredient_name]'" list="ingredients-list-edit" autocomplete="off" class="input-field" placeholder="Ketik atau pilih bahan..." :value="item.ingredient_name" @input="item.ingredient_name = $el.value">
                        </div>
                        <div class="w-24">
                            <input type="number" :name="'ingredients['+idx+'][amount]'" step="0.01" min="0.01" class="input-field" placeholder="2" :value="item.amount" @input="item.amount = $el.value">
                        </div>
                        <div class="w-28">
                            <select :name="'ingredients['+idx+'][unit]'" class="input-field" :value="item.unit" @change="item.unit = $el.value">
                                <option value="">Satuan</option>
                                <option value="sdm">sdm</option><option value="sdt">sdt</option><option value="buah">buah</option><option value="butir">butir</option><option value="siung">siung</option><option value="batang">batang</option><option value="lembar">lembar</option><option value="gram">gram</option><option value="kg">kg</option><option value="ml">ml</option><option value="liter">liter</option><option value="gelas">gelas</option><option value="piring">piring</option><option value="mangkuk">mangkuk</option><option value="cm">cm</option><option value="bungkus">bungkus</option><option value="sdm makan">sdm makan</option><option value="secukupnya">secukupnya</option>
                            </select>
                        </div>
                        <button type="button" @click="remove(idx)" class="text-red-400 hover:text-red-600 pb-2.5 text-xl" x-show="items.length > 1">&times;</button>
                    </div>
                </template>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8" x-data="stepManager({{ count($recipe->steps ?? []) }})">
            <div class="flex items-center justify-between mb-6"><h2 class="text-lg font-bold text-charcoal-500">📃 {{ __('ui.langkah_label') }}</h2><button type="button" @click="add()" class="text-amber-500 hover:text-amber-600 text-sm font-semibold">+ {{ __('ui.tambah_langkah') }}</button></div>
            <div class="space-y-3">
                <template x-for="(step, idx) in steps" :key="idx">
                    <div class="flex gap-3 items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-amber-400 text-white rounded-xl flex items-center justify-center font-bold text-sm mt-2" x-text="idx + 1"></span>
                        <div class="flex-1"><textarea name="steps[]" rows="2" required class="input-field" placeholder="{{ __('ui.tulis_langkah') }}" x-model="steps[idx]"></textarea></div>
                        <button type="button" @click="remove(idx)" class="text-red-400 hover:text-red-600 mt-2 text-xl" x-show="steps.length > 1">&times;</button>
                    </div>
                </template>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('recipes.show', $recipe) }}" class="btn-secondary">← {{ __('ui.batal') }}</a>
            <button type="submit" class="btn-primary text-lg px-10 py-3 gap-2">💿 {{ __('ui.simpan_perubahan') }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function ingredientManager(count) {
    const items = [];
    @foreach($recipe->ingredients as $i => $ing)
        items.push({ ingredient_name: '{{ $ing->name }}', amount: '{{ $ing->pivot->amount }}', unit: '{{ $ing->pivot->unit }}' });
    @endforeach
    if (items.length === 0) items.push({ ingredient_name: '', amount: '', unit: '' });
    return { items, add() { this.items.push({ ingredient_name: '', amount: '', unit: '' }); }, remove(idx) { if (this.items.length > 1) this.items.splice(idx, 1); } };
}

function stepManager(count) {
    const steps = @json(old('steps') ?: ($recipe->steps ?? ['']));
    return { steps, add() { this.steps.push(''); }, remove(idx) { if (this.steps.length > 1) this.steps.splice(idx, 1); } };
}

function previewImage(e) { const f = e.target.files[0]; if (f) { const r = new FileReader(); r.onload = ev => document.getElementById('cover-preview').src = ev.target.result; r.readAsDataURL(f); } }
</script>
@endpush

@extends('layouts.app')

@section('title', 'Buat Resep Baru')

@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
    #crop-overlay { z-index: 9999; }


    .cropper-view-box {
        border-radius: 20px;
        outline: 4px solid rgba(255,255,255,0.9);
        outline-offset: 0px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.6);
    }
    .cropper-face {
        border-radius: 20px;
        background: transparent !important;
    }


    .cropper-dashed {
        border: none !important;
        background:
            linear-gradient(to right, rgba(255,255,255,0.15) 1px, transparent 1px),
            linear-gradient(to right, rgba(255,255,255,0.15) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255,255,255,0.15) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255,255,255,0.15) 1px, transparent 1px);
        background-position: 33.33% 0, 66.66% 0, 0 33.33%, 0 66.66%;
        background-size: 1px 100%, 1px 100%, 100% 1px, 100% 1px;
        background-repeat: no-repeat;
    }


    .cropper-point {
        background-color: #fff;
        border: 2px solid rgba(0,0,0,0.2);
        width: 14px;
        height: 14px;
        border-radius: 7px;
    }
    .cropper-point.point-se { width: 10px; height: 10px; border-radius: 5px; }


    .cropper-center {
        background: rgba(255,255,255,0.5);
        width: 32px;
        height: 32px;
        border-radius: 16px;
        opacity: 0.6;
    }
    .cropper-center::before,
    .cropper-center::after {
        display: none;
    }


    .cropper-line {
        background-color: rgba(255,255,255,0.0);
    }


    .cropper-modal { opacity: 0; }


    #crop-wrapper {
        position: relative;
        width: 100%;
        max-width: 860px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow:
            0 0 0 1px rgba(255,255,255,0.08),
            0 20px 60px rgba(0,0,0,0.5);
    }
    #crop-image { display: block; max-width: 100%; }

    @media (max-width: 640px) {
        .cropper-view-box {
            border-radius: 14px;
            outline-width: 3px;
        }
        .cropper-face { border-radius: 14px; }
        .cropper-point { width: 12px; height: 12px; border-radius: 6px; }
        .cropper-point.point-se { width: 8px; height: 8px; }
        .cropper-center { width: 24px; height: 24px; border-radius: 12px; }
        #crop-wrapper { border-radius: 16px; }
    }
</style>
@endpush

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-display font-bold text-charcoal-500">{{ __('ui.buat_resep_baru') }}</h1>
        <p class="text-gray-400 mt-1">{{ __('ui.bagikan_resep_komunitas') }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 text-sm space-y-1">
            <p class="font-semibold mb-2">{{ __('ui.error_perbaiki') }}</p>
            @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-6 relative" id="recipe-form" onsubmit="document.getElementById('submit-overlay').style.display='flex'; return true;">
        @csrf

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
                    <p class="text-lg font-display font-bold text-charcoal-500">Menerbitkan resep...</p>
                    <p class="text-gray-400 text-sm mt-1">Mengunggah resep & foto ✨</p>
                </div>
    </div>
    </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">📃</span> {{ __('ui.informasi_resep') }}</h2>
            <div class="space-y-5">
                <div x-data="imageCropper()">
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.foto_masakan') }} <span class="text-gray-400 font-normal text-xs">(tampilkan hasil masakanmu)</span></label>
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-5">
                        <div class="relative w-full sm:w-48 h-36 rounded-xl border-2 border-dashed border-gray-200 flex-shrink-0 overflow-hidden bg-cream-50 group cursor-pointer" @click="$refs.fileInput.click()">
                            <img :src="preview" class="w-full h-full object-cover" x-show="hasImage">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400" x-show="!hasImage">
                                <span class="text-4xl mb-1">📷</span>
                                <span class="text-xs font-medium">Klik pilih gambar</span>
                            </div>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200" x-show="hasImage">
                                <span class="text-white text-xs font-bold bg-white/20 backdrop-blur px-3 py-1.5 rounded-full">✍️ {{ __('ui.ganti_crop') }}</span>
                            </div>
                        </div>
                        <div class="flex-1 w-full space-y-2">
                            <input type="file" x-ref="fileInput" accept="image/jpeg,image/png,image/webp" class="hidden" @change="onFileSelected($event)">
                            <input type="hidden" name="image_data" :value="croppedData">
                            <div class="flex flex-wrap items-center gap-2">
                                <button type="button" class="btn-secondary text-xs py-2 px-4" @click="$refs.fileInput.click()">
                                    📂 {{ __('ui.pilih_gambar') }}
                                </button>
                                <button type="button" class="btn-secondary text-xs py-2 px-4" x-show="hasImage" @click="openCropper()">
                                    ✂ Crop / Sesuaikan
                                </button>
                                <button type="button" class="text-xs text-red-400 hover:text-red-600 py-2 px-2 font-medium" x-show="hasImage" @click="removeImage()">
                                    🗑 {{ __('ui.hapus_gambar') }}
                                </button>
                            </div>
                            @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400">📷 {{ __('ui.foto_hint') }}</p>
                            <p class="text-xs text-gray-400 flex items-center gap-1" x-show="hasImage && imageSize">
                                ⬜ <span x-text="imageSize"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.judul_resep') }} <span class="text-red-400">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="input-field" placeholder="Nasi Goreng Spesial">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.deskripsi') }} <span class="text-red-400">*</span></label>
                    <textarea name="description" required rows="3" class="input-field" placeholder="{{ __('ui.deskripsi_placeholder') }}">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-charcoal-500 mb-2">{{ __('ui.tipe_resep') }} <span class="text-red-400">*</span></label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <label onclick="showRecipeType('food')" class="flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all {{ old('recipeable_type', 'food') === 'food' ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-gray-300' }}" id="food-label">
                            <input type="radio" name="recipeable_type" value="food" {{ old('recipeable_type', 'food') === 'food' ? 'checked' : '' }} class="hidden">
                            <span class="text-2xl">🥘</span>
                            <span class="font-medium text-charcoal-500">{{ __('ui.makanan') }}</span>
                        </label>
                        <label onclick="showRecipeType('drink')" class="flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all {{ old('recipeable_type') === 'drink' ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-gray-300' }}" id="drink-label">
                            <input type="radio" name="recipeable_type" value="drink" {{ old('recipeable_type') === 'drink' ? 'checked' : '' }} class="hidden">
                            <span class="text-2xl">🧋</span>
                            <span class="font-medium text-charcoal-500">{{ __('ui.minuman') }}</span>
                        </label>
                    </div>
                    @error('recipeable_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 {{ old('recipeable_type', 'food') === 'drink' ? 'hidden' : '' }}" id="food-detail">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">🥘</span> {{ __('ui.detail_makanan') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.waktu_masak') }}</label><input type="number" name="recipeable[cooking_time]" min="0" value="{{ old('recipeable.cooking_time', 30) }}" class="input-field" placeholder="Menit"></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.porsi') }}</label><input type="number" name="recipeable[serving_size]" min="1" value="{{ old('recipeable.serving_size', 4) }}" class="input-field" placeholder="Orang"></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.kalori') }}</label><input type="number" name="recipeable[calories]" min="0" value="{{ old('recipeable.calories', 250) }}" class="input-field" placeholder="kkal"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 {{ old('recipeable_type') === 'drink' ? '' : 'hidden' }}" id="drink-detail">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">🧋</span> {{ __('ui.detail_minuman') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.suhu') }}</label><select name="recipeable[is_cold]" class="input-field"><option value="1" {{ old('recipeable.is_cold', '1') === '1' ? 'selected' : '' }}>🧊 {{ __('ui.dingin') }}</option><option value="0" {{ old('recipeable.is_cold') === '0' ? 'selected' : '' }}>☕ {{ __('ui.panas') }}</option></select></div>
                <div><label class="block text-sm font-medium text-charcoal-500 mb-1.5">{{ __('ui.tipe_gelas') }}</label><input type="text" name="recipeable[glass_type]" value="{{ old('recipeable.glass_type') }}" class="input-field" placeholder="Highball, Mug..."></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h2 class="text-lg font-bold text-charcoal-500 mb-6 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">🏷</span> {{ __('ui.kategori_label') }}</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $cat)
                    <label class="flex items-center gap-2 cursor-pointer px-4 py-2.5 rounded-xl border transition-all {{ in_array($cat->id, old('categories', [])) ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                        <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', [])) ? 'checked' : '' }} class="text-amber-400 focus:ring-amber-400 rounded">
                        <span class="text-sm font-medium text-charcoal-500">{{ $cat->getLocalizedName() }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8" x-data="ingredientManager()">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-charcoal-500 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">🧄</span> {{ __('ui.bahan_label') }}</h2>
                <button type="button" @click="add()" class="text-amber-500 hover:text-amber-600 text-sm font-semibold">+ {{ __('ui.tambah_bahan') }}</button>
            </div>
            <datalist id="ingredients-list">
                @foreach($ingredients as $ing)
                    <option value="{{ $ing->name }}">{{ $ing->name }}</option>
                @endforeach
            </datalist>
            <div class="space-y-3">
                <template x-for="(item, idx) in items" :key="idx">
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 items-stretch sm:items-end">
                        <div class="flex-1">
                            <input type="text" :name="'ingredients['+idx+'][ingredient_name]'" list="ingredients-list" autocomplete="off" class="input-field" placeholder="Ketik atau pilih bahan..." :value="item.ingredient_name" @input="item.ingredient_name = $el.value">
                        </div>
                        <div class="w-full sm:w-24">
                            <input type="number" :name="'ingredients['+idx+'][amount]'" step="0.01" min="0.01" class="input-field" placeholder="2" :value="item.amount" @input="item.amount = $el.value">
                        </div>
                        <div class="w-full sm:w-28">
                            <select :name="'ingredients['+idx+'][unit]'" class="input-field" :value="item.unit" @change="item.unit = $el.value">
                                <option value="">{{ __('ui.pilih_satuan') }}</option>
                                <optgroup label="⬜ Volume Cair">
                                    <option value="ml">ml (mililiter)</option>
                                    <option value="liter">liter</option>
                                    <option value="gelas">gelas</option>
                                    <option value="cangkir">cangkir</option>
                                    <option value="mangkuk">mangkuk</option>
                                </optgroup>
                                <optgroup label="🥄 Sendok">
                                    <option value="sdm">sdm (sendok makan)</option>
                                    <option value="sdt">sdt (sendok teh)</option>
                                    <option value="sendok">sendok</option>
                                </optgroup>
                                <optgroup label="⚖ Berat">
                                    <option value="gram">gram</option>
                                    <option value="kg">kg (kilogram)</option>
                                    <option value="ons">ons</option>
                                    <option value="mg">mg (miligram)</option>
                                </optgroup>
                                <optgroup label="🧺 Utuh / Butir">
                                    <option value="buah">buah</option>
                                    <option value="butir">butir</option>
                                    <option value="biji">biji</option>
                                    <option value="siung">siung</option>
                                    <option value="batang">batang</option>
                                    <option value="lembar">lembar</option>
                                    <option value="helai">helai</option>
                                    <option value="potong">potong</option>
                                    <option value="iris">iris</option>
                                    <option value="ekor">ekor</option>
                                    <option value="bonggol">bonggol</option>
                                    <option value="rumpun">rumpun</option>
                                    <option value="ikat">ikat</option>
                                    <option value="bungkus">bungkus</option>
                                    <option value="bungkusan">bungkusan</option>
                                    <option value="kotak">kotak</option>
                                    <option value="kaleng">kaleng</option>
                                    <option value="botol">botol</option>
                                    <option value="papan">papan</option>
                                    <option value="plastik">plastik</option>
                                    <option value="sachet">sachet</option>
                                    <option value="balok">balok</option>
                                </optgroup>
                                <optgroup label="📐 Ukuran">
                                    <option value="cm">cm (sentimeter)</option>
                                    <option value="inci">inci</option>
                                    <option value="ruas">ruas</option>
                                    <option value="jari">jari</option>
                                    <option value="jempol">jempol</option>
                                </optgroup>
                                <optgroup label="🍽 Porsi / Takaran">
                                    <option value="piring">piring</option>
                                    <option value="porsi">porsi</option>
                                    <option value="orang">orang</option>
                                    <option value="tusuk">tusuk</option>
                                    <option value="tangkup">tangkup</option>
                                    <option value="genggam">genggam</option>
                                    <option value="jumput">jumput</option>
                                    <option value="cubit">cubit / sejumput</option>
                                    <option value="secukupnya">secukupnya</option>
                                    <option value="seperlunya">seperlunya</option>
                                </optgroup>
                            </select>
                        </div>
                        <button type="button" @click="remove(idx)" class="text-red-400 hover:text-red-600 pb-2.5 text-xl" x-show="items.length > 1">&times;</button>
                    </div>
                </template>
            </div>
            @error('ingredients.*')<p class="text-red-500 text-xs mt-2">Periksa data bahan yang dimasukkan</p>@enderror
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8" x-data="stepManager()">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-charcoal-500 flex items-center gap-2"><span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm">📃</span> {{ __('ui.langkah_label') }}</h2>
                <button type="button" @click="add()" class="text-amber-500 hover:text-amber-600 text-sm font-semibold">+ {{ __('ui.tambah_langkah') }}</button>
            </div>
            <div class="space-y-3">
                <template x-for="(step, idx) in steps" :key="idx">
                    <div class="flex gap-2 sm:gap-3 items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-amber-400 text-white rounded-xl flex items-center justify-center font-bold text-sm mt-2" x-text="idx + 1"></span>
                        <div class="flex-1">
                            <textarea name="steps[]" rows="2" required class="input-field" placeholder="{{ __('ui.tulis_langkah') }}"></textarea>
                        </div>
                        <button type="button" @click="remove(idx)" class="text-red-400 hover:text-red-600 mt-2 text-xl" x-show="steps.length > 1">&times;</button>
                    </div>
                </template>
            </div>
            @error('steps.*')<p class="text-red-500 text-xs mt-2">Setiap langkah harus diisi</p>@enderror
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('recipes.index') }}" class="btn-secondary">← {{ __('ui.batal') }}</a>
            <button type="submit" class="btn-primary text-lg px-10 py-3 gap-2">{{ __('ui.publikasikan_resep') }}</button>
        </div>
    </form>
</div>

<div id="crop-overlay" class="fixed inset-0 z-[9999] hidden flex flex-col bg-[#0a0a0a]" x-data="{ show: false }" x-show="show" x-transition.opacity.duration.300ms>
    <div class="flex items-center justify-between px-4 sm:px-6 py-3 flex-shrink-0 bg-gradient-to-b from-black/80 via-black/40 to-transparent absolute top-0 left-0 right-0 z-10">
        <button type="button" class="flex items-center gap-2 text-white/70 hover:text-white text-sm font-medium transition-colors px-3 py-2 rounded-xl hover:bg-white/10" onclick="window._cancelCrop()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span class="hidden sm:inline">{{ __('ui.batal') }}</span>
        </button>
        <div class="text-center">
            <p class="text-white text-sm sm:text-base font-bold">✂ Sesuaikan Gambar</p>
            <p class="text-white/50 text-[10px] sm:text-xs">Geser & cubit - rasio 4:3</p>
        </div>
        <button type="button" class="flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-walnut-900 font-bold text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl transition-all duration-200 shadow-lg shadow-amber-500/25 active:scale-95" onclick="window._applyCrop()">
            <span class="hidden sm:inline">✅ Terapkan</span>
            <span class="sm:hidden">✅</span>
        </button>
    </div>

    <div class="flex-1 flex items-center justify-center overflow-hidden px-0 sm:px-6 md:px-12 py-0 sm:py-6">
        <div id="crop-wrapper" class="rounded-xl sm:rounded-2xl overflow-hidden shadow-2xl shadow-black/50">
            <img id="crop-image" src="" alt="">
        </div>
    </div>

    <div class="flex-shrink-0 bg-gradient-to-t from-black/80 to-transparent absolute bottom-0 left-0 right-0 z-10 px-4 sm:px-6 py-4 sm:py-5">
        <div class="max-w-lg mx-auto flex flex-col gap-3 sm:gap-4">
            <div class="flex items-center justify-center gap-4 sm:gap-6">
                <button type="button" class="flex flex-col items-center gap-1.5 text-white/60 hover:text-white transition-colors group" onclick="window._cropperInstance && window._cropperInstance.rotate(-90)">
                    <span class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all text-xl">↺</span>
                    <span class="text-[10px] font-medium">Putar</span>
                </button>
                <button type="button" class="flex flex-col items-center gap-1.5 text-white/60 hover:text-white transition-colors group" onclick="window._cropperInstance && window._cropperInstance.scaleX(window._cropperInstance.getImageData().scaleX * -1)">
                    <span class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all text-xl">↔</span>
                    <span class="text-[10px] font-medium">Flip</span>
                </button>
                <button type="button" class="flex flex-col items-center gap-1.5 text-white/60 hover:text-white transition-colors group" onclick="window._cropperInstance && window._cropperInstance.reset()">
                    <span class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-all text-xl">🔁</span>
                    <span class="text-[10px] font-medium">Reset</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
function showRecipeType(type) {
    document.getElementById('food-detail').className = type === 'food' ? document.getElementById('food-detail').className.replace('hidden','').replace('  ',' ') : (document.getElementById('food-detail').className + ' hidden');
    document.getElementById('drink-detail').className = type === 'drink' ? document.getElementById('drink-detail').className.replace('hidden','').replace('  ',' ') : (document.getElementById('drink-detail').className + ' hidden');
    document.getElementById('food-label').className  = type === 'food' ? 'flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-amber-400 bg-amber-50' : 'flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300';
    document.getElementById('drink-label').className = type === 'drink' ? 'flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-amber-400 bg-amber-50' : 'flex-1 flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300';
    document.querySelector('input[name=recipeable_type][value='+type+']').checked = true;
}
function imageCropper() {
    return {
        preview: 'https://placehold.co/400x300/F8F4EE/9ca3af?text=Pilih+Gambar',
        hasImage: false,
        croppedData: '',
        originalFile: null,
        imageSize: '',

        onFileSelected(e) {
            const file = e.target.files[0];
            if (!file) return;
            if (file.size > 20 * 1024 * 1024) {
                alert('Ukuran gambar tidak boleh lebih dari 20MB.');
                e.target.value = '';
                return;
            }
            this.originalFile = file;
            this.imageSize = this.formatSize(file.size);
            const reader = new FileReader();
            reader.onload = (ev) => {
                this.preview = ev.target.result;
                this.hasImage = true;
                this.openCropper(ev.target.result);
            };
            reader.readAsDataURL(file);
            e.target.value = '';
        },

        openCropper(dataUrl) {
            const src = dataUrl || this.preview;
            if (!src || src.includes('placehold.co')) return;
            const overlay = document.getElementById('crop-overlay');
            const img = document.getElementById('crop-image');
            img.src = src;
            overlay.style.display = 'flex';
            if (window._cropperInstance) window._cropperInstance.destroy();
            window._cropperInstance = new Cropper(img, {
                viewMode: 2,
                autoCropArea: 0.85,
                responsive: true,
                background: false,
                aspectRatio: 4 / 3,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                dragMode: 'move',
            });
            window._cancelCrop = () => {
                if (window._cropperInstance) window._cropperInstance.destroy();
                window._cropperInstance = null;
                overlay.style.display = 'none';
                img.src = '';
            };
            window._applyCrop = () => {
                if (!window._cropperInstance) return;
                const canvas = window._cropperInstance.getCroppedCanvas({ maxWidth: 1920, maxHeight: 1920 });
                canvas.toBlob((blob) => {
                    const url = URL.createObjectURL(blob);
                    this.preview = url;
                    this.hasImage = true;
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        this.croppedData = reader.result;
                    };
                    reader.readAsDataURL(blob);
                    this.imageSize = this.formatSize(blob.size);
                }, 'image/jpeg', 0.9);
                window._cropperInstance.destroy();
                window._cropperInstance = null;
                overlay.style.display = 'none';
                img.src = '';
            };
        },

        removeImage() {
            this.preview = 'https://placehold.co/400x300/F8F4EE/9ca3af?text=Pilih+Gambar';
            this.hasImage = false;
            this.croppedData = '';
            this.originalFile = null;
            this.imageSize = '';
            const overlay = document.getElementById('crop-overlay');
            overlay.style.display = 'none';
            if (window._cropperInstance) {
                window._cropperInstance.destroy();
                window._cropperInstance = null;
            }
        },

        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(2) + ' MB';
        }
    };
}

function recipeForm() {
    return {
        type: '{{ old('recipeable_type', 'food') }}',
        submitting: false,
    };
}

function ingredientManager() {
    return {
        items: @json(old('ingredients') ?? [['ingredient_name' => '', 'amount' => '', 'unit' => '']]),
        add() { this.items.push({ ingredient_name: '', amount: '', unit: '' }); },
        remove(idx) { if (this.items.length > 1) this.items.splice(idx, 1); },
    };
}

function stepManager() {
    return {
        steps: @json(old('steps') ?? ['']),
        add() { this.steps.push(''); },
        remove(idx) { if (this.steps.length > 1) this.steps.splice(idx, 1); },
    };
}
</script>
@endpush

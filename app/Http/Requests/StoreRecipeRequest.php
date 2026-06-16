<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'steps' => ['nullable', 'array'],
            'steps.*' => ['required', 'string'],
            'recipeable_type' => ['required', 'in:food,drink'],
            'recipeable' => ['required', 'array'],
            'recipeable.cooking_time' => ['required_if:recipeable_type,food', 'integer', 'min:0'],
            'recipeable.serving_size' => ['required_if:recipeable_type,food', 'integer', 'min:1'],
            'recipeable.calories' => ['required_if:recipeable_type,food', 'integer', 'min:0'],
            'recipeable.is_cold' => ['required_if:recipeable_type,drink', 'boolean'],
            'recipeable.glass_type' => ['nullable', 'string', 'max:100'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.ingredient_id' => ['nullable', 'exists:ingredients,id'],
            'ingredients.*.ingredient_name' => ['nullable', 'string', 'max:100'],
            'ingredients.*.amount' => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul resep wajib diisi.',
            'title.max' => 'Judul resep maksimal 255 karakter.',
            'description.required' => 'Deskripsi resep wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 20MB.',
            'steps.*.required' => 'Setiap langkah harus diisi.',
            'recipeable_type.required' => 'Tipe resep wajib dipilih.',
            'recipeable_type.in' => 'Tipe resep harus Makanan atau Minuman.',
            'recipeable.cooking_time.required_if' => 'Waktu masak wajib diisi untuk resep makanan.',
            'recipeable.cooking_time.min' => 'Waktu masak tidak boleh negatif.',
            'recipeable.serving_size.required_if' => 'Jumlah porsi wajib diisi untuk resep makanan.',
            'recipeable.serving_size.min' => 'Jumlah porsi minimal 1 orang.',
            'recipeable.calories.required_if' => 'Jumlah kalori wajib diisi untuk resep makanan.',
            'recipeable.is_cold.required_if' => 'Suhu penyajian wajib dipilih untuk resep minuman.',
            'ingredients.*.amount.required' => 'Jumlah bahan wajib diisi.',
            'ingredients.*.amount.min' => 'Jumlah bahan tidak boleh negatif.',
            'ingredients.*.unit.required' => 'Satuan bahan wajib dipilih.',
            'categories.*.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}

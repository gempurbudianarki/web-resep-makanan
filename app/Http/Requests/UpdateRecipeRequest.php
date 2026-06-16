<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'steps' => ['nullable', 'array'],
            'steps.*' => ['required', 'string'],
            'recipeable' => ['nullable', 'array'],
            'recipeable.cooking_time' => ['sometimes', 'integer', 'min:0'],
            'recipeable.serving_size' => ['sometimes', 'integer', 'min:1'],
            'recipeable.calories' => ['sometimes', 'integer', 'min:0'],
            'recipeable.is_cold' => ['sometimes', 'boolean'],
            'recipeable.glass_type' => ['nullable', 'string', 'max:100'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.ingredient_id' => ['nullable', 'exists:ingredients,id'],
            'ingredients.*.ingredient_name' => ['nullable', 'string', 'max:100'],
            'ingredients.*.amount' => ['required', 'numeric', 'min:0'],
            'ingredients.*.unit' => ['required', 'string', 'max:50'],
            'status' => ['sometimes', 'in:published,draft'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'Judul resep maksimal 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 20MB.',
            'steps.*.required' => 'Setiap langkah harus diisi.',
            'ingredients.*.amount.required' => 'Jumlah bahan wajib diisi.',
            'ingredients.*.amount.min' => 'Jumlah bahan tidak boleh negatif.',
            'ingredients.*.unit.required' => 'Satuan bahan wajib dipilih.',
            'categories.*.exists' => 'Kategori yang dipilih tidak valid.',
            'status.in' => 'Status harus published atau draft.',
        ];
    }
}

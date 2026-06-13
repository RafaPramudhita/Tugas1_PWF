<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'quantity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama produk wajib diisi.',
            'name.string'          => 'Nama produk harus berupa teks.',
            'name.max'             => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi produk wajib diisi.',
            'description.string'   => 'Deskripsi produk harus berupa teks.',

            'quantity.required'    => 'Stok produk wajib diisi.',
            'quantity.integer'     => 'Stok produk harus berupa angka bulat.',
            'quantity.min'         => 'Stok produk minimal 1.',

            'price.required'       => 'Harga produk wajib diisi.',
            'price.numeric'        => 'Harga produk harus berupa angka yang valid.',
            'price.min'            => 'Harga produk tidak boleh kurang dari 0.',
        ];
    }
}

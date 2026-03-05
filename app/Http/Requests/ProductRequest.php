<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->has('deal_date')) {
            return [
                'deal_date' => 'nullable|after_or_equal:today',
                'deal_status' => 'nullable'
            ];
        }
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            'category_id' => 'required|exists:categories,id',

            'brand_name' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255|unique:products,model,',
            'sku' => 'nullable|string|max:255|unique:products,sku,',

            'stock' => 'nullable|min:0',
            'minstock' => 'nullable|min:0',

            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',


            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'gall_img' => 'nullable|image|mimes:jpg,jpeg,png,webp',

            'published_status' => 'nullable|string',
            'published_date' => 'nullable',

        ];
    }
}

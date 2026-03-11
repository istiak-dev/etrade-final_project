<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'title' => 'required|min:3|max:60',
             'icon' => 'nullable|mimes:png,jpeg,jpg,webp'
        ];
    }

    function messages()
    {
        return [
            'title.required' => "Please enter a title!",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    public static function rules($categoryId = null): array
    {
        $baseRules = [
            'name'   => ['required', 'string', 'max:100'],
            'image'  => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:3000'],
            'status' => ['nullable']
        ];

        if ($categoryId) {
            $baseRules['name'][] = 'unique:categories,name,' . $categoryId;
            $baseRules['status'][] = ['required', 'boolean'];
        } else {
            $baseRules['name'][] = 'unique:categories,name';
        }

        return $baseRules;
    }
}

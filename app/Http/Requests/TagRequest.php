<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
    public static function rules($tagId = null): array
    {
        $baseRules = [
            'name'   => ['required', 'string', 'max:100'],
        ];

        if ($tagId) {
            $baseRules['name'][] = 'unique:tags,name,' . $tagId;
        } else {
            $baseRules['name'][] = 'unique:tags,name';
        }

        return $baseRules;
    }
}

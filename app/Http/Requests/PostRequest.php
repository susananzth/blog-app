<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public static function rules($postId = null): array
    {
        $baseRules = [
            'title'   => ['required', 'string', 'max:200'],
            'image'   => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:3000'],
            'body'    => ['required', 'string'],
            'status'  => ['nullable'],
        ];

        if ($postId) {
            $baseRules['title'][]  = 'unique:posts,title,' . $postId;
            $baseRules['status'][] = ['required', 'boolean'];
        } else {
            $baseRules['title'][] = 'unique:posts,title';
            $baseRules['status'][] = ['required', 'boolean'];
        }

        return $baseRules;
    }
}

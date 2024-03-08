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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($postId = null): array
    {
        $baseRules = [
            'title'   => ['required', 'string', 'max:200'],
            'image'   => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:3000'],
            'body'    => ['required', 'string'],
            'status'  => ['required', 'boolean'],
        ];

        if ($postId) {
            $baseRules['title'][]  = 'unique:posts,title,' . $postId;
        } else {
            $baseRules['title'][] = 'unique:posts,title';
        }

        return $baseRules;
    }
}

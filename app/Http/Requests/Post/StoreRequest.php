<?php

namespace App\Http\Requests\Post;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('post_add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'      => ['bail', 'required', 'string', 'max:200', 'unique:posts,title'],
            'body'       => ['bail', 'required', 'string'],
            'status'     => ['bail', 'required', 'boolean'],
            'category'   => ['bail', 'nullable', 'array'],
            'category.*' => ['bail', 'sometimes', 'exists:categories,id'],
        ];
    }
}

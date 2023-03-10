<?php

namespace App\Http\Requests\Post;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('post_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'      => 'bail|required|string|max:200|unique:posts,title,' . $this->post['id'],
            'cover'      => 'bail|nullable|file|mimes:jpg,jpeg,png|max:3000',
            'body'       => 'bail|required|string',
            'status'     => 'bail|required|boolean',
            'category'   => 'bail|nullable|array',
            'category.*' => 'bail|sometimes|exists:categories,id',
            'tag'        => 'bail|nullable|array',
            'tag.*'      => 'bail|sometimes|exists:tags,id',
        ];
    }
}

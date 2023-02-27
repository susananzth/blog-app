<?php

namespace App\Http\Requests\Tag;

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
        return Gate::allows('tag_add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:100', 'unique:tags,name'],
        ];
    }
}

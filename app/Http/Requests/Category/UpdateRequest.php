<?php

namespace App\Http\Requests\Category;

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
        return Gate::allows('category_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => 'bail|required|string|max:100|unique:categories,name,' . $this->category['id'],
            'image' => 'bail|nullable|file|mimes:jpg,jpeg,png|max:3000',
        ];
    }
}

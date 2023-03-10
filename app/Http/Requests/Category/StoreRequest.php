<?php

namespace App\Http\Requests\Category;

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
        return Gate::allows('category_add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => 'bail|required|string|max:100|unique:categories,name',
            'image' => 'bail|nullable|file|mimes:jpg,jpeg,png|max:3000',
        ];
    }
}

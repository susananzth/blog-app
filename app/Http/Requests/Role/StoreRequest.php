<?php

namespace App\Http\Requests\Role;

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
        return Gate::allows('role_add');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         => 'required|string|unique:roles|max:255',
            'permission'    => 'required|array',
            'permission.*'  => 'sometimes|integer|exists:permissions,id',
        ];
    }
}

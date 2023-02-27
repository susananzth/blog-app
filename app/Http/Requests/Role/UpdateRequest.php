<?php

namespace App\Http\Requests\Role;

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
        return Gate::allows('role_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         => ['bail', 'required', 'string', 'max:100', 'unique:roles,title,' . $this->role['id']],
            'permission'    => ['bail', 'required', 'array'],
            'permission.*'  => ['bail', 'sometimes', 'integer', 'exists:permissions,id'],
        ];
    }
}

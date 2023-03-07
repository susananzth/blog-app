<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'        => ['bail', 'required', 'string', 'max:255'],
            'email'       => ['bail', 'required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'    => ['bail', 'required', 'confirmed', Password::defaults()],
            'pic_profile' => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png', 'max:3000'],
        ];
    }
}

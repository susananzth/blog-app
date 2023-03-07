<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreFormRequest;
use Illuminate\Auth\Events\Registered;


class RegisteredUserController extends Controller
{
    public function store(StoreFormRequest $request)
    {
        $inputs = $request->validated();
        $user = User::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
        ]);

        event(new Registered($user));

        $data['token'] = $user->createToken('BlogApp')->accessToken;
        $data['name']  = $user->name;

        Auth::check($user);

        return $this->successResponse($data, 'User register successfully.');
    }
}

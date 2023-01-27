<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::attempt([
            'email'    => $request->email, 
            'password' => $request->password
        ])) { 

            $user = Auth::user(); 

            $data['token'] = $user->createToken('MyApp')->plainTextToken; 
            $data['name']  = $user->name;

            return $this->successResponse($data,'User login successfully.');

        } else { 

            return $this->errorResponse(
                'These credentials do not match our records.', 
                Response::HTTP_UNPROCESSABLE_ENTITY);

        } 
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        auth('sanctum')->user()->tokens()->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->successResponse('', 'User logout.');
    }
}

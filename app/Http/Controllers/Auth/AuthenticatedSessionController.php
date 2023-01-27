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

            $success['token'] = $user->createToken('MyApp')->plainTextToken; 
            $success['name']  = $user->name;

            return $this->sendResponse(
                $success, 
                'User login successfully.', 
                Response::HTTP_OK);

        } else { 

            return $this->sendError(
                'These credentials do not match our records.', 
                ['error'=>'These credentials do not match our records.'], 
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

        return $this->sendResponse('', 'User logout.');
    }
}

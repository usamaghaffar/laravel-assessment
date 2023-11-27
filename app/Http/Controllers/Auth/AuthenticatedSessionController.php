<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        if(Auth::attempt(['email' =>$request->get('email'), 'password' => $request->get('password')])){ 

            $user = Auth::user(); 
            $token = $user->createToken('token')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } 


        return response()->json('Please check your credentials');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}

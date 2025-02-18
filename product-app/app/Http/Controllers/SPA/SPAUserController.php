<?php

namespace App\Http\Controllers\SPA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SPAUserController extends Controller
{
    /**
     * Log in the user if the credentials get validated
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $loggedIn = Auth::attempt($attributes);

        Validator::make(
            ['email' => $loggedIn],
            ['email' => 'accepted']
        )->validate();

        $token = $request->user()->createToken('API TOKEN')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Logs the current user out
     */
    public function logout()
    {
        Auth::guard('web')->logout();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    /**
     * use login method
     */
    public function login(Request $request)
    {
        $credenciales = $request->only('email', 'password');
        if (Auth::attempt($credenciales)) {
            $user = Auth::user();
            $token = $user->createToken('superadminToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }
    }

    /**
     * use register method
     */
    public function register(Request $request) {
        dump($request->getContent());
        die;
    }
}

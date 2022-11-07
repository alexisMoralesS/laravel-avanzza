<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function  singIn(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('fileApi')->accessToken;
            return response()->json(["token" => $token], 202);
        }
        return response()->json(['message' => 'El usuairo o contraseña no exite.'], 202);
    }
}

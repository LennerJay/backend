<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return response()->json([
            'token' => 'testToken'
        ]);
    }

    public function logout(Request $request)
    {

    }
}

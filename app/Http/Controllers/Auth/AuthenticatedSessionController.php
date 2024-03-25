<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {
            
           
            // TOKEN
            $token = $request->user()->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'token' => $token]);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}

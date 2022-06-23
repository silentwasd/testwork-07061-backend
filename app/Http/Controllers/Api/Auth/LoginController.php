<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                Password::min(8)
            ]
        ]);

        if (Auth::attempt($validated)) {
            $user = Auth::user();

            $token = $user->createToken('user', [
                'board-item:create',
                'board-item:update-owns',
                'board-item:remove-owns',
                'board-item:close-owns'
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token->plainTextToken
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => [
                'message' => 'The provided credentials do not match our records.'
            ]
        ], 401);
    }

    public function logout(Request $request)
    {
        $deleted = $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => (bool)$deleted]);
    }
}

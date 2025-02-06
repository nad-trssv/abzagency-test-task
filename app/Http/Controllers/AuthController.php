<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function token(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!empty($user)) { 
            $token = $user->createToken('auth_token', ['*'], now()->addMinutes(40))->plainTextToken;

            return response()->json([
                "status" => true,
                "user" => $user,
                "token" => $token,
            ]);
        } else {
            return response()->json([
                "status" => false,
            ]);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => 'You has been logged out!',
        ]);
    }

}

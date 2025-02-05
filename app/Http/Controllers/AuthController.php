<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function token(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!empty($user)) {
            $token = $user->createToken('auth_token')->plainTextToken;
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

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => 'You has been logged out!',
        ]);
    }

}

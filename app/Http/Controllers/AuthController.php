<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function protectedRoute(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'token' => $request->bearerToken(),
            'user' => new UserResource($request->user()),
        ]);
    }
}

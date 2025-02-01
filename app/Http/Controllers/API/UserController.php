<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {   
        $data = $this->userService->list();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $data = $this->userService->store($validatedData);
            return response()->json($data, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }

    }
}

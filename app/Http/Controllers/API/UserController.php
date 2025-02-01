<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
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
        try {
            return response()->json([
                'status' => true,
                'data' => UserResource::collection($this->userService->list()),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $data = $this->userService->store($validatedData);
            return response()->json([
                'status' => true,
                'data' => new UserResource($data),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }

    }
}

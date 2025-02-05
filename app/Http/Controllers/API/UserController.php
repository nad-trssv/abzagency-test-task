<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
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
            $users = $this->userService->list();

            return response()->json([
                'success' => true,
                'total_pages' => $users->lastPage(),
                'total_users' => $users->total(),
                'count' => $users->perPage(),
                'page' => $users->currentPage(),
                'links' => [
                    'next' => $users->nextPageUrl(),
                    'prev' => $users->previousPageUrl(),
                ],
                'users' => UserResource::collection($users->items()),
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $data = $this->userService->store($validatedData);
            return response()->json([
                'success' => true,
                'user_id' => $data->id,
                "message" => "New user successfully registered"
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function show(User $user): JsonResponse
    {
        try {

            return response()->json([
                'success' => true,
                'user' => new UserResource($user),
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Services\PositionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private PositionService $positionService;
    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }
    
    public function index(): JsonResponse
    {   
        try {
            $positions = $this->positionService->list();

            return response()->json([
                'success' => true,
                'positions' => PositionResource::collection($positions),
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => "Positions not found",
            ], 422);
        }
    }
}

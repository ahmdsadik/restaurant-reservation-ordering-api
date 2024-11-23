<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Services\MealService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MealController extends Controller
{
    public function __construct(protected MealService $mealService) {}

    /**
     * List all meals
     */
    public function listMenu(): JsonResponse
    {
        try {
            $meals = $this->mealService->listMenu();

            return $this->successResponse(
                [
                    'menu' => MealResource::collection($meals),
                ],
                'Meals retrieved successfully.'
            );
        } catch (\Throwable $throwable) {
            Log::error('Error retrieving meals', [
                'message' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
            ]);

            return $this->errorResponse('Something went wrong while retrieving meals.');
        }
    }
}

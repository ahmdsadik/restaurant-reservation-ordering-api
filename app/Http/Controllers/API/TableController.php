<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckAvailabilityRequest;
use App\Http\Resources\TableResource;
use App\Services\TableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function __construct(protected TableService $tableService) {}

    /**
     * Check availability of tables
     */
    public function checkAvailability(CheckAvailabilityRequest $request): JsonResponse
    {
        try {
            $availableTables = $this->tableService->checkAvailability(
                $request->validated('guests'),
                $request->validated('from_time'),
                $request->validated('to_time')
            );

            return $this->successResponse(
                [
                    'tables' => TableResource::collection($availableTables),
                ],
                'Tables available for the requested time.'
            );
        } catch (\Throwable $throwable) {
            Log::error('Error while checking availability', [
                'message' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
            ]);

            return $this->errorResponse('Something went wrong while checking availability.');
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveTableRequest;
use App\Http\Resources\ReservationResource;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservationService) {}

    /**
     * Reserve a table
     */
    public function reserveTable(ReserveTableRequest $request): JsonResponse
    {
        try {
            $result = $this->reservationService->reserveTable($request->validated());

            if (isset($result['waiting_list'])) {
                return $this->successResponse(
                    message: 'No tables available for the requested time. You were added to the waiting list.'
                );
            }

            return $this->successResponse(
                [
                    'reservation' => ReservationResource::make($result['reservation']->load('table', 'customer')),
                ],
                'Table reserved successfully'
            );
        } catch (\Throwable $throwable) {
            Log::error('Error while reserving table', [
                'message' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
            ]);

            return $this->errorResponse('Something went wrong while reserving table');
        }
    }
}

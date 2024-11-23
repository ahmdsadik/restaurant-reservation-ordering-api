<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InsufficientMealQuantityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    /**
     * Create a new order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return $this->successResponse([
                'order' => OrderResource::make($order),
            ], 'Order created successfully.');
        } catch (InsufficientMealQuantityException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $throwable) {
            Log::error('Error while creating order', [
                'message' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
            ]);

            return $this->errorResponse('Something went wrong while creating order.');
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Exceptions\OrderIsAlreadyPaidException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct(protected CheckoutService $checkoutService) {}

    /**
     * Checkout an order
     */
    public function checkout(Order $order): JsonResponse
    {
        try {
            $order = $this->checkoutService->checkoutOrder($order);

            return $this->successResponse(
                [
                    'invoice' => CheckoutResource::make($order),
                ],
                'Checkout successful.'
            );
        } catch (OrderIsAlreadyPaidException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $throwable) {
            Log::error('Error during checkout', [
                'message' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
            ]);

            return $this->errorResponse('Something went wrong during checkout. Please try again later.');
        }
    }
}

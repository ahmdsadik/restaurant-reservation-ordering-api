<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\OrderIsAlreadyPaidException;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class CheckoutService
{
    public function __construct(protected OrderRepositoryInterface $orderRepository) {}

    /**
     * Checkout an order
     *
     * @throws OrderIsAlreadyPaidException
     */
    public function checkoutOrder(Order $order): Order
    {
        if ($order->paid === OrderStatus::PAID) {
            throw new OrderIsAlreadyPaidException($order->id);
        }

        $this->orderRepository->updateOrderStatus($order, OrderStatus::PAID);

        return $order->load(['customer:id,name', 'orderDetails.meal']);
    }
}

<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Create a new order
     */
    public function createOrder(array $orderData, array $orderDetails): Order
    {
        $order = Order::create($orderData);
        $order->orderDetails()->createMany($orderDetails);

        return $order;
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Order $order, OrderStatus $status): bool
    {
        return $order->update(['paid' => $status]);
    }
}

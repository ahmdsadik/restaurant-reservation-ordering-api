<?php

namespace App\Repositories\Interfaces;

use App\Enums\OrderStatus;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function createOrder(array $orderData, array $orderDetails): Order;

    public function updateOrderStatus(Order $order, OrderStatus $status): bool;
}

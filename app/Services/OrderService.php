<?php

namespace App\Services;

use App\Exceptions\InsufficientMealQuantityException;
use App\Models\Order;
use App\Repositories\Interfaces\MealRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected ReservationRepositoryInterface $reservationRepository,
        protected MealRepositoryInterface $mealRepository
    ) {}

    /**
     * Create a new order
     *
     * @return Order|mixed
     */
    public function createOrder(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $reservation = $this->reservationRepository->findReservationById($data['reservation_id']);

            $customer = $reservation->customer;
            $table = $reservation->table;

            $mealIds = array_column($data['meals'], 'meal_id');
            $orderedMeals = $this->mealRepository->getMealsByIds($mealIds, true);

            $totalAmount = 0;
            $orderDetails = [];

            foreach ($data['meals'] as $orderedMeal) {
                $meal = $orderedMeals[$orderedMeal['meal_id']];
                $quantity = $orderedMeal['quantity'];

                if (! $meal->available($quantity)) {
                    throw new InsufficientMealQuantityException($meal->description);
                }

                $amountToPay = $meal->applyDiscount() * $quantity;
                $totalAmount += $amountToPay;

                $orderDetails[] = [
                    'meal_id' => $meal->id,
                    'quantity' => $quantity,
                    'amount_to_pay' => $amountToPay,
                ];
            }

            $orderData = [
                'table_id' => $table->id,
                'reservation_id' => $reservation->id,
                'customer_id' => $customer->id,
                'waiter_id' => $data['waiter_id'],
                'total' => $totalAmount,
            ];

            return $this->orderRepository->createOrder($orderData, $orderDetails)->load('orderDetails.meal');
        });
    }
}

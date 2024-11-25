<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(),
            'paid' => OrderStatus::NOT_PAID,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'table_id' => Table::factory(),
            'reservation_id' => Reservation::factory(),
            'customer_id' => Customer::factory(),
            'waiter_id' => Waiter::factory(),
        ];
    }
}

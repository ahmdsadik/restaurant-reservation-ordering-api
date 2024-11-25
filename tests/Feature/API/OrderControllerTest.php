<?php

namespace Feature\API;

use App\Exceptions\InsufficientMealQuantityException;
use App\Models\Customer;
use App\Models\Meal;
use App\Models\Reservation;
use App\Models\Waiter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_order_validation_works(): void
    {
        $order_data = [
            'waiter_id' => 1,
            'customer_id' => 1,
            'reservation_id' => 31,
            'meals' => [
                [
                    'meal_id' => 15,
                    'quantity' => 2,
                ],
                [
                    'meal_id' => 20,
                    'quantity' => 3,
                ],
            ],
        ];

        $res = $this->postJson('api/order', $order_data);

        $res->assertStatus(422);
        $res->assertJsonCount(5, 'message');
        $this->assertDatabaseMissing('orders', [
            'waiter_id' => 1,
            'customer_id' => 1,
            'reservation_id' => 31,
        ]);
    }

    public function test_store_order_return_order_details_successfully(): void
    {
        $waiter = Waiter::factory()->create();
        $customer = Customer::factory()->create();
        $reservation = Reservation::factory()->create();
        $meal = Meal::factory()->create(['quantity_available' => 5]);
        $meal2 = Meal::factory()->create(['quantity_available' => 4]);

        $order_data = [
            'waiter_id' => $waiter->id,
            'customer_id' => $customer->id,
            'reservation_id' => $reservation->id,
            'meals' => [
                [
                    'meal_id' => $meal->id,
                    'quantity' => 2,
                ],
                [
                    'meal_id' => $meal2->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $res = $this->postJson('api/order', $order_data);

        $res->assertStatus(200);
        $res->assertJsonStructure([
            'order',
        ]);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'id' => $res->json('order.id'),
            'waiter_id' => $waiter->id,
            'reservation_id' => $reservation->id,
            'table_id' => $reservation->table_id,
        ]);
        $this->assertDatabaseCount('order_details', 2);
        $this->assertDatabaseHas('order_details', [
            'meal_id' => $meal->id,
            'quantity' => 2,
            'amount_to_pay' => $meal->applyDiscount() * 2,
        ]);
        $this->assertDatabaseHas('order_details', [
            'meal_id' => $meal2->id,
            'quantity' => 2,
            'amount_to_pay' => $meal2->applyDiscount() * 2,
        ]);
        $this->assertDatabaseHas('meals', [
            'id' => $meal->id,
            'quantity_available' => $meal->quantity_available - 2,
        ]);
    }

    public function test_store_order_fails_when_ordering_a_non_available_meal_or_out_of_stock(): void
    {
        $waiter = Waiter::factory()->create();
        $customer = Customer::factory()->create();
        $reservation = Reservation::factory()->create();
        $meal = Meal::factory()->create(['quantity_available' => 1]);

        $order_data = [
            'waiter_id' => $waiter->id,
            'customer_id' => $customer->id,
            'reservation_id' => $reservation->id,
            'meals' => [
                [
                    'meal_id' => $meal->id,
                    'quantity' => 3,
                ],
            ],
        ];

        $res = $this->postJson('api/order', $order_data);

        $res->assertStatus(422);
        $res->assertJsonFragment([
            'message' => (new InsufficientMealQuantityException($meal->description))->getMessage(),
        ]);
    }
}

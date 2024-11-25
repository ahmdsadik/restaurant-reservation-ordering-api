<?php

namespace Feature\API;

use App\Enums\OrderStatus;
use App\Exceptions\OrderIsAlreadyPaidException;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_returns_success_response_when_order_is_not_paid(): void
    {
        $order = Order::factory()->create([
            'paid' => OrderStatus::NOT_PAID,
        ]);

        $res = $this->postJson("/api/checkout/$order->id");

        $res->assertStatus(200);
        $res->assertExactJsonStructure([
            'status',
            'message',
            'invoice',
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'paid' => OrderStatus::PAID->value,
        ]);
    }

    public function test_checkout_returns_error_response_when_order_is_paid(): void
    {
        $order = Order::factory()->create([
            'paid' => OrderStatus::PAID,
        ]);

        $res = $this->postJson("/api/checkout/$order->id");

        $res->assertStatus(422);
        $res->assertJsonFragment([
            'message' => (new OrderIsAlreadyPaidException($order->id))->getMessage(),
        ]);
        $res->assertExactJsonStructure([
            'status',
            'message',
        ]);
    }

    public function test_checkout_catches_the_not_found_order_and_returns_normal_response(): void
    {
        $res = $this->postJson('/api/checkout/55');

        $res->assertStatus(401);
    }
}

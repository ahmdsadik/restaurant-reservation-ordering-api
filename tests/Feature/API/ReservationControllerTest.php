<?php

namespace Feature\API;

use App\Models\Customer;
use App\Models\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reserve_table_validation_works(): void
    {
        $res = $this->postJson('api/reserve-table', [
            'customer_id' => 2,
            'from_time' => '2024-12-05 18:00',
            'to_time' => '2024-12-05 20:00',
            'guests' => 10,
        ]);

        $res->assertStatus(422);
        $res->assertJsonFragment([
            'status' => false,
        ]);
    }

    public function test_reserve_table_return_added_to_waiting_l_ist_when_there_is_no_tables(): void
    {
        $customer = Customer::factory()->create();

        $res = $this->postJson('api/reserve-table', [
            'customer_id' => $customer->id,
            'from_time' => '2024-12-05 18:00',
            'to_time' => '2024-12-05 20:00',
            'guests' => 10,
        ]);

        $this->assertDatabaseCount('waiting_lists', 1);
        $this->assertDatabaseHas('waiting_lists', [
            'customer_id' => $customer->id,
            'from_time' => '2024-12-05 18:00:00',
            'to_time' => '2024-12-05 20:00:00',
            'guests' => 10,
        ]);
        $res->assertStatus(200);
        $res->assertJsonFragment([
            'message' => 'No tables available for the requested time. You were added to the waiting list.',
        ]);
    }

    public function test_reserve_table_return_reservation_information(): void
    {
        $customer = Customer::factory()->create();
        $table = Table::factory()->create(['capacity' => 10]);

        $res = $this->postJson('api/reserve-table', [
            'customer_id' => $customer->id,
            'from_time' => '2024-12-05 18:00',
            'to_time' => '2024-12-05 20:00',
            'guests' => 10,
        ]);

        $this->assertDatabaseCount('reservations', 1);
        $this->assertDatabaseHas('reservations', [
            'customer_id' => $customer->id,
        ]);
        $res->assertStatus(200);
        $res->assertJsonStructure([
            'reservation',
        ]);
        $this->assertEquals($table->id, $res->json('reservation.table.id'));
    }
}

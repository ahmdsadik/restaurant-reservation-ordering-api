<?php

namespace Feature\API;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_availability_validation_works(): void
    {
        $res = $this->getJson('api/check-availability', [
            'from_time' => '2024-12-05 18:00',
            'to_time' => '2024-12-05 20:00',
        ]);

        $res->assertStatus(422);
    }

    public function test_check_availability_returns_available_tables(): void
    {
        $table = Table::factory()->create([
            'capacity' => 5,
        ]);

        $res = $this->getJson('api/check-availability?from_time=2024-12-05 18:00&to_time=2024-12-05 20:00&guests=2');

        $res->assertStatus(200);
        $res->assertJsonCount(1, 'tables');
        $this->assertDatabaseCount('tables', 1);
        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'capacity' => $table->capacity,
        ]);
    }

    public function test_check_availability_returns_empty_tables_when_there_no_available_table(): void
    {
        $res = $this->getJson('api/check-availability?from_time=2024-12-05 18:00&to_time=2024-12-05 20:00&guests=2');

        $res->assertStatus(200);
        $res->assertJsonCount(0, 'tables');
        $this->assertDatabaseEmpty('tables', 0);
    }

    public function test_check_availability_returns_empty_tables_when_all_tables_are_not_available(): void
    {
        $table = Table::factory()->create(['capacity' => 5]);
        $reservation = Reservation::factory()->create([
            'table_id' => $table->id,
            'from_time' => '2024-12-05 18:00',
            'to_time' => '2024-12-05 20:00',
        ]);

        $res = $this->getJson('api/check-availability?from_time=2024-12-05 18:00&to_time=2024-12-05 20:00&guests=2');

        $res->assertStatus(200);
        $res->assertJsonCount(0, 'tables');
        $this->assertDatabaseCount('tables', 1);
        $this->assertDatabaseCount('reservations', 1);
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'table_id' => $table->id,
        ]);
    }
}

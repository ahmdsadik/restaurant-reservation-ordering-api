<?php

namespace Feature\API;

use App\Models\Meal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MealControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_menu_returns_empty_menu(): void
    {
        $res = $this->getJson('/api/menu');

        $res->assertStatus(200);

        $res->assertJsonStructure([
            'status',
            'message',
            'menu',
        ]);
        $this->assertEquals([], $res->json('menu'));
        $this->assertTrue($res->json('status'));
    }

    public function test_list_menu_returns_menu(): void
    {
        $meals = Meal::factory(10)->create();

        $res = $this->getJson('/api/menu');

        $res->assertStatus(200);
        $res->assertJsonStructure([
            'status',
            'message',
            'menu',
        ]);
        $res->assertJsonCount(10, 'menu');
        $this->assertDatabaseCount('meals', 10);
        $meals->each(function (Meal $meal) {
            $this->assertDatabaseHas('meals', [
                'id' => $meal->id,
                'description' => $meal->description,
                'quantity_available' => $meal->quantity_available,
            ]);
        });
    }
}

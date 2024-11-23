<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition(): array
    {

        $meals = [
            'Caesar Salad',
            'Garlic Bread',
            'Bruschetta',
            'Grilled Chicken Alfredo',
            'Beef Stroganoff',
            'Spaghetti Bolognese',
            'Margherita Pizza',
            'Teriyaki Salmon',
            'Chicken Tikka Masala',
            'BBQ Ribs',
            'Vegan Buddha Bowl',
            'Mushroom Risotto',
            'Lamb Chops with Mint Sauce',
            'Chocolate Lava Cake',
            'Cheesecake',
            'Tiramisu',
            'Apple Pie',
            'Banana Split',
            'Creme Brulee',
            'Vegetable Stir Fry',
        ];

        return [
            'price' => $this->faker->randomFloat(2, 20, 500),
            'description' => $this->faker->randomElement($meals),
            'quantity_available' => $this->faker->randomDigit(),
            'discount' => $this->faker->randomFloat(2, max: 2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

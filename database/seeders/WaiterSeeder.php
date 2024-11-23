<?php

namespace Database\Seeders;

use App\Models\Waiter;
use Illuminate\Database\Seeder;

class WaiterSeeder extends Seeder
{
    public function run(): void
    {
        Waiter::factory(5)->create();
    }
}

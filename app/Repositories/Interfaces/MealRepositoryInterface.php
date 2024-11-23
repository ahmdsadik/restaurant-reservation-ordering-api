<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface MealRepositoryInterface
{
    public function getAllMeals(): Collection;

    public function getMealsByIds(array $ids, bool $lock = false): Collection;
}

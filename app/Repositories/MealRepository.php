<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Meal;
use App\Repositories\Interfaces\MealRepositoryInterface;
use Illuminate\Support\Collection;

class MealRepository implements MealRepositoryInterface
{
    /**
     * Get all meals
     */
    public function getAllMeals(): Collection
    {
        return Meal::all();
    }

    /**
     * Get meals by IDs
     */
    public function getMealsByIds(array $ids, bool $lock = false): Collection
    {
        $query = Meal::whereIn('id', $ids);
        if ($lock) {
            $query->lockForUpdate();
        }

        return $query->get()->keyBy('id');
    }
}

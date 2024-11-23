<?php

namespace App\Services;

use App\Repositories\Interfaces\MealRepositoryInterface;
use Illuminate\Support\Collection;

class MealService
{
    public function __construct(protected MealRepositoryInterface $mealRepository) {}

    /**
     * List menu
     */
    public function listMenu(): Collection
    {
        return $this->mealRepository->getAllMeals();
    }
}

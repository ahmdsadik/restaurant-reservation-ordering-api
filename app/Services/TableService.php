<?php

namespace App\Services;

use App\Repositories\Interfaces\TableRepositoryInterface;
use Illuminate\Support\Collection;

class TableService
{
    public function __construct(protected TableRepositoryInterface $tableRepository) {}

    /**
     * Check table availability
     */
    public function checkAvailability(int $guests, string $fromTime, string $toTime): Collection
    {
        return $this->tableRepository->findAvailableTables($guests, $fromTime, $toTime);
    }
}

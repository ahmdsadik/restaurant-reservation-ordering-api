<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface TableRepositoryInterface
{
    public function findAvailableTables(int $guests, string $fromTime, string $toTime): Collection;
}

<?php

namespace App\Repositories;

use App\Models\Table;
use Illuminate\Support\Collection;

class TableRepository implements Interfaces\TableRepositoryInterface
{
    /**
     * Find available tables
     */
    public function findAvailableTables(int $guests, string $fromTime, string $toTime): Collection
    {
        return Table::available($guests, $fromTime, $toTime)->get();
    }
}

<?php

namespace App\Repositories;

use App\Models\WaitingList;
use App\Repositories\Interfaces\WaitingListRepositoryInterface;

class WaitingListRepository implements WaitingListRepositoryInterface
{
    /**
     * Add to waiting list
     */
    public function addToWaitingList(array $data): WaitingList
    {
        return WaitingList::create($data);
    }
}

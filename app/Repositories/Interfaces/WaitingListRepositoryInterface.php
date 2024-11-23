<?php

namespace App\Repositories\Interfaces;

use App\Models\WaitingList;

interface WaitingListRepositoryInterface
{
    public function addToWaitingList(array $data): WaitingList;
}

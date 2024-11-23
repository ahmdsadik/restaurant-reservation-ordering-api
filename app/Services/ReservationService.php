<?php

namespace App\Services;

use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\TableRepositoryInterface;
use App\Repositories\Interfaces\WaitingListRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function __construct(
        protected ReservationRepositoryInterface $reservationRepository,
        protected TableRepositoryInterface $tableRepository,
        protected WaitingListRepositoryInterface $waitingListRepository
    ) {}

    /**
     * Reserve a table
     *
     * @return array|mixed|true[]
     */
    public function reserveTable(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            $availableTable = $this->tableRepository->findAvailableTables(
                $data['guests'],
                $data['from_time'],
                $data['to_time']
            )->first();

            if (! $availableTable) {
                // Add to waiting list
                $this->waitingListRepository->addToWaitingList($data);

                return ['waiting_list' => true];
            }

            $data['table_id'] = $availableTable->id;
            $reservation = $this->reservationRepository->createReservation($data);

            return ['reservation' => $reservation];
        });
    }
}

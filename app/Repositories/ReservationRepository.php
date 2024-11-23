<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function createReservation(array $data): Reservation
    {
        return Reservation::create($data);
    }

    /**
     * Find a reservation by ID
     */
    public function findReservationById(int $id): ?Reservation
    {
        return Reservation::with(['table', 'customer'])->find($id);
    }
}

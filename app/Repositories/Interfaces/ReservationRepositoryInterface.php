<?php

namespace App\Repositories\Interfaces;

use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function createReservation(array $data): Reservation;

    public function findReservationById(int $id): ?Reservation;
}

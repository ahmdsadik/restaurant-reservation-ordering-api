<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Reservation */
class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from' => $this->from_time->format('Y-m-d H:i'),
            'to' => $this->to_time->format('Y-m-d H:i'),

            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'table' => TableResource::make($this->whenLoaded('table')),
        ];
    }
}

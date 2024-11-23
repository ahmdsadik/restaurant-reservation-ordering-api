<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => ceil($this->total),
            'date' => $this->created_at->format('d-m-Y H:i'),

            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'reservation' => ReservationResource::make($this->whenLoaded('reservation')),
            'table' => TableResource::make($this->whenLoaded('table')),
            'details' => OrderDetailsResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}

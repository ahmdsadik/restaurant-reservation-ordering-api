<?php

namespace App\Http\Resources;

use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin WaitingList */
class WaitingListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'guests' => $this->guests,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'customer_id' => $this->customer_id,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}

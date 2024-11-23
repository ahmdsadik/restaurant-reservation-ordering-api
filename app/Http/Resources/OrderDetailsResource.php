<?php

namespace App\Http\Resources;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrderDetail */
class OrderDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount_to_pay' => $this->amount_to_pay,
            'quantity' => $this->quantity,
            'meal' => MealResource::make($this->whenLoaded('meal')),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrderDetail */
class CheckoutItemsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'meal' => $this->meal->description,
            'quantity' => $this->quantity,
            'paid' => $this->amount_to_pay,
        ];
    }
}

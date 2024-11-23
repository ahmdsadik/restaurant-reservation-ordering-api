<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class CheckoutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'date' => $this->created_at->format('Y-m-d H:i'),
            'customer' => $this->customer->name,
            'table_number' => $this->table_id,
            'items' => CheckoutItemsResource::collection($this->orderDetails),
            'total' => $this->total,
        ];
    }
}

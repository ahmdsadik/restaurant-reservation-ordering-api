<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderDetail extends Pivot
{
    protected $fillable = [
        'order_id',
        'meal_id',
        'quantity',
        'amount_to_pay',
    ];

    protected $table = 'order_details';

    public $timestamps = false;

    protected static function booted()
    {
        self::created(function (OrderDetail $orderDetail) {
            $orderDetail->meal()->decrement('quantity_available', $orderDetail->quantity);
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}

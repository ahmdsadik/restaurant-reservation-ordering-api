<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'reservation_id',
        'customer_id',
        'waiter_id',
        'total',
        'paid',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function waiter(): BelongsTo
    {
        return $this->belongsTo(Waiter::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    protected function casts(): array
    {
        return [
            'paid' => OrderStatus::class,
        ];
    }
}

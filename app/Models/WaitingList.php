<?php

namespace App\Models;

use App\Enums\WaitingListStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaitingList extends Model
{
    protected $fillable = [
        'customer_id',
        'guests',
        'from_time',
        'to_time',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    protected function casts(): array
    {
        return [
            'from_time' => 'datetime',
            'to_time' => 'datetime',
            'status' => WaitingListStatus::class,
        ];
    }
}

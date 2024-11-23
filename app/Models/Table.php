<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'table_id');
    }

    /**
     * Scope a query to only include tables that are available between given times.
     */
    public function scopeAvailable(Builder $query, int $capacity, string $from, string $to): Builder
    {
        return $query->where('capacity', '>=', $capacity)
            ->whereDoesntHave('reservations', function ($query) use ($from, $to) {
                $query->where(function ($query) use ($from, $to) {
                    $query->whereBetween('from_time', [$from, $to])
                        ->orWhereBetween('to_time', [$from, $to])
                        ->orWhere(function ($query) use ($from, $to) {
                            $query->where('from_time', '<', $from)
                                ->where('to_time', '>', $to);
                        });
                });
            });
    }
}

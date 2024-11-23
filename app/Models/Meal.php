<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'description',
        'quantity_available',
        'discount',
    ];

    /**
     * Check if a meal is available
     */
    public function available(int $quantity): bool
    {
        return $this->quantity_available >= $quantity;
    }

    /**
     * Apply Meal Discount
     */
    public function applyDiscount(): float
    {
        return $this->price - ($this->price * ($this->discount / 100));
    }
}

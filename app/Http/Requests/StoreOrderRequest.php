<?php

namespace App\Http\Requests;

use App\Traits\ApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    use ApiValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'reservation_id' => ['required', 'exists:reservations,id'],
            'waiter_id' => ['required', 'exists:waiters,id'],
            'meals' => ['required', 'array'],
            'meals.*.meal_id' => ['required', 'exists:meals,id'],
            'meals.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Traits\ApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class ReserveTableRequest extends FormRequest
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
            'from_time' => ['required', 'date_format:Y-m-d H:i', 'before:to', 'after_or_equal:today'],
            'to_time' => ['required', 'date_format:Y-m-d H:i', 'after:from', 'after_or_equal:today'],
            'guests' => ['required', 'integer', 'min:1'],
        ];
    }
}
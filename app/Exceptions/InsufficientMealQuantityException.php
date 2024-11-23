<?php

namespace App\Exceptions;

use Exception;

class InsufficientMealQuantityException extends Exception
{
    public function __construct(string $mealDescription)
    {
        $message = "Meal {$mealDescription} is not available now.";
        parent::__construct($message);
    }
}

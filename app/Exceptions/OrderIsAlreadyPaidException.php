<?php

namespace App\Exceptions;

use Exception;

class OrderIsAlreadyPaidException extends Exception
{
    public function __construct(int $orderId)
    {
        $message = "Order no. {$orderId} is already paid.";
        parent::__construct($message);
    }
}

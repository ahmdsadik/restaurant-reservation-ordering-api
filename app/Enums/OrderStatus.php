<?php

namespace App\Enums;

use App\Traits\EnumHelpers;

enum OrderStatus: int
{
    use EnumHelpers;

    case PAID = 1;
    case NOT_PAID = 2;
}

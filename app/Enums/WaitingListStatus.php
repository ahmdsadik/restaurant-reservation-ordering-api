<?php

namespace App\Enums;

use App\Traits\EnumHelpers;

enum WaitingListStatus: int
{
    use EnumHelpers;

    case WAITING = 1;
    case NOTIFIED = 2;
    case CANCELED = 3;
}

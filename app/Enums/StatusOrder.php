<?php

namespace App\Enums;

use App\Traits\EnumContract;

enum StatusOrder: int
{
    use EnumContract;

    case WAITING = 1;
    case PREPARATION = 2;
    case READY = 3;
    case DELIVERED = 4;
}

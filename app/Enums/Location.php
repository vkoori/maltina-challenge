<?php

namespace App\Enums;

use App\Traits\EnumContract;

enum Location: int
{
    use EnumContract;

    case IN_SHOP = 1;
    case OUT_SHOP = 2;
}

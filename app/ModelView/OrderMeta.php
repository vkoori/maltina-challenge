<?php

namespace App\ModelView;

use App\Enums\Location;
use App\Enums\StatusOrder;

class OrderMeta
{
    public static function object(): array
    {
        $location = Location::keyValue();
        $status = StatusOrder::keyValue();

        return compact('location', 'status');
    }

    public static function list(): array
    {
        $location = Location::keyValue();
        $status = StatusOrder::keyValue();

        return compact('location', 'status');
    }
}

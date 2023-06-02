<?php

namespace App\Constraint;

use App\Dto\OrderList as DtoOrderList;
use App\Enums\Location;
use App\Models\Order;

interface OrderRepository extends BaseReadRepository
{
    public function singleOrderSave(
        string $uuid,
        int $productId,
        ?int $typeId,
        int $count,
        float $price,
        Location $consumeLocation
    ): Order;

    public function bulkOrderSave(string $uuid, DtoOrderList $items): bool;
}

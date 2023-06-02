<?php

namespace App\Constraint;

use App\Dto\OrderList as DtoOrderList;
use Illuminate\Support\Collection;

interface PriceRepository extends BaseReadRepository
{
    public function getPrice(int $productId, ?int $typeId): float;
    public function getPrices(DtoOrderList $list): Collection;
}

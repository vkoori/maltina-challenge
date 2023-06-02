<?php

namespace App\Repositories;

use App\Constraint\PriceRepository as ConstraintPriceRepository;
use App\Dto\OrderList as DtoOrderList;
use App\Dto\OrderObject as DtoOrderObject;
use App\Models\Price;
use Illuminate\Support\Collection;

class PriceRepository extends BaseReadRepository implements ConstraintPriceRepository
{
    public function __construct()
    {
        $this->model = new Price();
    }

    public function getPrice(int $productId, ?int $typeId): float
    {
        return $this
            ->getModel()
            ->priceFinder($productId, $typeId)
            ->firstOrFail()
            ->price;
    }

    public function getPrices(DtoOrderList $list): Collection
    {
        $query = $this->getModel()->query();
        
        $list->getOrders()->each(function (DtoOrderObject $item) use ($query) {
            $query->priceFinder($item->getProductId(), $item->getTypeId());
        });
        
        return $query->get();
    }
}

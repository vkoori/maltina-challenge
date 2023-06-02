<?php

namespace App\Service\Order\Pipelines;

use App\Dto\OrderList as DtoOrderList;
use App\Errors\Http\ProductNotFound;
use App\Facade\PriceRepositoryFacade;
use App\Models\Price;
use Closure;

class PriceFinder
{
    public function handle(DtoOrderList $dto, Closure $next)
    {
        $prices = PriceRepositoryFacade::getPrices(list: $dto);

        if ($prices->count() != $dto->getOrders()->count()) {
            throw new ProductNotFound;
        }

        $prices->each(function (Price $price) use ($dto) {
            $dto
                ->getOrder(productId: $price->product_id, typeId: $price->type_id)
                ->setPrice(price: $price->price);
        });

        return $next($dto);
    }
}

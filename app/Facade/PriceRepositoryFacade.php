<?php

namespace App\Facade;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;
use App\Dto\OrderList as DtoOrderList;
use Illuminate\Support\Collection;

/**
 * @method static LengthAwarePaginator paginate(int $perPage = 10, array $columns = ['*'], array $relations = [], ?string $sortBy = null, string $sortType = 'asc')
 * @method static float getPrice(int $productId, ?int $typeId)
 * @method static Collection getPrices(DtoOrderList $list)
 *
* @see \App\Constraint\PriceRepository::class
 */
class PriceRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'price-queries';
    }
}

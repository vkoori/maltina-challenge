<?php

namespace App\Facade;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static LengthAwarePaginator paginate(int $perPage = 10, array $columns = ['*'], array $relations = [], ?string $sortBy = null, string $sortType = 'asc')
 *
* @see \App\Constraint\ProductRepository::class
 */
class ProductRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-queries';
    }
}

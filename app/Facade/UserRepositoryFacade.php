<?php

namespace App\Facade;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static LengthAwarePaginator paginate(int $perPage = 10, array $columns = ['*'], array $relations = [], ?string $sortBy = null, string $sortType = 'asc')
 * @method static Product findOrFail(int $modelId, array $columns = ['*'], array $relations = [])
 *
* @see \App\Constraint\ProductRepository::class
 */
class UserRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user-queries';
    }
}

<?php

namespace App\Facade;

use App\Models\Type;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static LengthAwarePaginator paginate(int $perPage = 10, array $columns = ['*'], array $relations = [], ?string $sortBy = null, string $sortType = 'asc')
 * @method static Collection<Type> getAllTypesOfProduct(int $productId)
 *
 * @see \App\Constraint\TypeRepository::class
 */
class TypeRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'type-queries';
    }
}

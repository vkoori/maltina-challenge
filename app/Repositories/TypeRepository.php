<?php

namespace App\Repositories;

use App\Constraint\TypeRepository as ConstraintTypeRepository;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TypeRepository extends BaseReadRepository implements ConstraintTypeRepository
{
    public function __construct()
    {
        $this->model = new Type;
    }

    public function getAllTypesOfProduct(int $productId): Collection
    {
        return $this
            ->getModel()
            ->whereHas('typeGroup', function (Builder $group) use ($productId) {
                $group->productId($productId);
            })->get();
    }
}

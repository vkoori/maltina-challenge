<?php

namespace App\Constraint;

use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;

interface TypeRepository extends BaseReadRepository
{
    /**
     * There is no need to use a `chunk()`, because it is always short
     *
     * @param integer $productId
     * @return Collection<Type>
     */
    public function getAllTypesOfProduct(int $productId): Collection;
}

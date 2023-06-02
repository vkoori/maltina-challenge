<?php

namespace App\Repositories;

use App\Constraint\BaseReadRepository as ConstraintBaseReadRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseReadRepository extends BaseRepository implements ConstraintBaseReadRepository
{
    public function paginate(
        int $perPage = 10,
        array $columns = ['*'],
        array $relations = [],
        ?string $sortBy = null,
        string $sortType = 'desc'
    ): LengthAwarePaginator {
        return $this
            ->getModel()
            ->with($relations)
            ->orderBy($sortBy ? $sortBy : $this->model->getQualifiedKeyName(), $sortType)
            ->paginate($perPage, $columns);
    }
}

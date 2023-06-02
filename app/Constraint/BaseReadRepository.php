<?php

namespace App\Constraint;

use Illuminate\Pagination\LengthAwarePaginator;

interface BaseReadRepository extends BaseRepository
{
    public function paginate(
        int $perPage = 10,
        array $columns = ['*'],
        array $relations = [],
        ?string $sortBy = null,
        string $sortType = 'asc'
    ): LengthAwarePaginator;
}

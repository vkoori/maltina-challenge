<?php

namespace App\Constraint;

use Illuminate\Database\Eloquent\Model;
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

    public function findOrFail(
        int $modelId,
        array $columns = ['*'],
        array $relations = []
    ): Model;
}

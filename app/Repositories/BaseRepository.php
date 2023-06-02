<?php

namespace App\Repositories;

use App\Constraint\BaseRepository as ConstraintBaseRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements ConstraintBaseRepository
{
    protected Model $model;

    public function getModel(): Model
    {
        return $this->model;
    }
}

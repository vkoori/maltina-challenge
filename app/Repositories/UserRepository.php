<?php

namespace App\Repositories;

use App\Constraint\UserRepository as ConstraintUserRepository;
use App\Models\User;

class UserRepository extends BaseReadRepository implements ConstraintUserRepository
{
    public function __construct()
    {
        $this->model = new User();
    }
}

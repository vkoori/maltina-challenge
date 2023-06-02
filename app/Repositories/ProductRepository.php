<?php

namespace App\Repositories;

use App\Constraint\ProductRepository as ConstraintProductRepository;
use App\Models\Product;

class ProductRepository extends BaseReadRepository implements ConstraintProductRepository
{
    public function __construct()
    {
        $this->model = new Product();
    }
}

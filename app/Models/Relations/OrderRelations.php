<?php

namespace App\Models\Relations;

use App\Models\Product;
use App\Models\Type;

trait OrderRelations
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}

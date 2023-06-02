<?php

namespace App\Models\Relations;

use App\Models\Product;

trait PriceRelations
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

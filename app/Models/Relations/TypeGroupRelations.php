<?php

namespace App\Models\Relations;

use App\Models\Product;
use App\Models\Type;

trait TypeGroupRelations
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function types()
    {
        return $this->hasMany(Type::class, 'type_group_id');
    }
}

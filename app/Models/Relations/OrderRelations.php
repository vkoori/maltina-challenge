<?php

namespace App\Models\Relations;

use App\Models\Product;
use App\Models\Type;
use App\Models\User;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

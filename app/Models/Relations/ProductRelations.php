<?php

namespace App\Models\Relations;

use App\Models\Order;
use App\Models\Price;
use App\Models\Type;
use App\Models\TypeGroup;

trait ProductRelations
{
    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id');
    }

    public function typeGroup()
    {
        return $this->hasOne(TypeGroup::class, 'product_id');
    }

    public function types()
    {
        return $this->hasManyThrough(Type::class, TypeGroup::class, 'product_id', 'type_group_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
}

<?php

namespace App\Models\Relations;

use App\Models\Order;
use App\Models\TypeGroup;

trait TypeRelations
{
    public function typeGroup()
    {
        return $this->belongsTo(TypeGroup::class, 'type_group_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'type_id');
    }
}

<?php

namespace App\Models\Relations;

use App\Models\Order;

trait UserRelations
{
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}

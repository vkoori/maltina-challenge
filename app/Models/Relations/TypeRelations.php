<?php

namespace App\Models\Relations;

use App\Models\TypeGroup;

trait TypeRelations
{
    public function typeGroup()
    {
        return $this->belongsTo(TypeGroup::class, 'type_group_id');
    }
}

<?php

namespace App\Transformers\Type;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListView extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return $this->collection->map(function (Type $type) {
            return [
                "type_id"        => $type->id,
                "type_name"      => $type->name,
            ];
        });
    }
}

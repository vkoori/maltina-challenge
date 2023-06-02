<?php

namespace App\Transformers\Price;

use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListView extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return $this->collection->map(function (Price $price) {
            return [
                "type_id"        => $price->type_id,
                "price"          => $price->price
            ];
        });
    }
}

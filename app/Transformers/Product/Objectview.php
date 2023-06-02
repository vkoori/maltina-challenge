<?php

namespace App\Transformers\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transformers\TypeGroup\ObjectView as TypeGroupObjectView;
use App\Transformers\Price\ListView as PriceListView;

class ObjectView extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'product_id'        => $this->id,
            'product_name'      => $this->name,
            'groups'            => $this->relationLoaded('typeGroup')
                ? TypeGroupObjectView::make($this->typeGroup)
                : null,
            'prices'            => $this->relationLoaded('prices')
                ? PriceListView::make($this->prices)
                : null
        ];
    }
}

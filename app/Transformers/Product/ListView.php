<?php

namespace App\Transformers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Transformers\Price\ListView as PriceListView;
use App\Transformers\TypeGroup\ObjectView as TypeGroupObjectView;

class ListView extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return $this->collection->map(function (Product $product) {
            return [
                "product_id"        => $product->id,
                "product_name"      => $product->name,
                "groups"            => $product->relationLoaded('typeGroup')
                    ? TypeGroupObjectView::make($product->typeGroup)
                    : null,
                "prices"            => $product->relationLoaded('prices')
                    ? PriceListView::make($product->prices)
                    : null
            ];
        });
    }
}

<?php

namespace App\Transformers\Order;

use App\ModelView\OrderMeta;
use App\Transformers\Product\ObjectView as ProductObjectView;
use App\Transformers\Type\ObjectView as TypeObjectView;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObjectView extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'order_id'      => $this->id,
            'invoice_id'    => $this->invoice_id,
            'product'       => $this->whenLoaded(
                relationship: 'product',
                value: fn () => ProductObjectView::make($this->product),
                default: $this->product_id
            ),
            'type'          => $this->whenLoaded(
                relationship: 'type',
                value: fn () => TypeObjectView::make($this->type),
                default: $this->type_id
            ),
            'count'         => $this->count,
            'price'         => $this->price,
            'location'      => $this->consume_location,
            'status'        => $this->status,
            'created_at'    => $this->created_at,
        ];
    }

    public function with(Request $request)
    {
        return OrderMeta::object();
    }
}

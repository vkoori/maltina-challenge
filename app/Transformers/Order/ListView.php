<?php

namespace App\Transformers\Order;

use App\Models\Order;
use App\ModelView\OrderMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Transformers\Product\ObjectView as ProductObjectView;
use App\Transformers\Type\ObjectView as TypeObjectView;

class ListView extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return $this->collection->map(function (Order $order) {
            return [
                'order_id'      => $order->id,
                'invoice_id'    => $order->invoice_id,
                'product'       => $order->relationLoaded('product')
                    ? ProductObjectView::make($order->product)
                    : $order->product_id,
                'type'          => $order->relationLoaded('type')
                    ? TypeObjectView::make($order->type)
                    : $order->type_id,
                'count'         => $order->count,
                'price'         => $order->price,
                'location'      => $order->consume_location,
                'status'        => $order->status,
                'created_at'    => $order->created_at,
            ];
        });
    }

    public function with(Request $request)
    {
        return OrderMeta::list();
    }
}

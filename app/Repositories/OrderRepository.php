<?php

namespace App\Repositories;

use App\Constraint\OrderRepository as ConstraintOrderRepository;
use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Models\Order;
use App\Dto\OrderList as DtoOrderList;
use App\Dto\OrderObject as DtoOrderObject;

class OrderRepository extends BaseReadRepository implements ConstraintOrderRepository
{
    public function __construct()
    {
        $this->model = new Order();
    }

    public function singleOrderSave(
        string $uuid,
        int $productId,
        ?int $typeId,
        int $count,
        float $price,
        Location $consumeLocation
    ): Order {
        /** @var Order $order */
        $order = $this->getModel();
        $order->invoice_id = $uuid;
        $order->product_id = $productId;
        $order->type_id = $typeId;
        $order->count = $count;
        $order->price = $price;
        $order->consume_location = $consumeLocation;
        $order->status = StatusOrder::WAITING;
        $order->saveOrFail();
        return $order;
    }

    public function bulkOrderSave(string $uuid, DtoOrderList $items): bool
    {
        $payload = [];

        $items->getOrders()->each(function (DtoOrderObject $item) use (&$payload, $uuid) {
            array_push($payload, [
                'invoice_id'        => $uuid,
                'product_id'        => $item->getProductId(),
                'type_id'           => $item->getTypeId(),
                'count'             => $item->getCount(),
                'price'             => $item->getPrice(),
                'consume_location'  => $item->getLocation(),
                'status'            => StatusOrder::WAITING,
            ]);
        });

        return $this->getModel()->insert($payload);
    }
}

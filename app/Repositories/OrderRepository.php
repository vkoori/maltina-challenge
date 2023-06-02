<?php

namespace App\Repositories;

use App\Constraint\OrderRepository as ConstraintOrderRepository;
use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Models\Order;
use App\Dto\OrderList as DtoOrderList;
use App\Dto\OrderObject as DtoOrderObject;
use Illuminate\Support\Collection;

class OrderRepository extends BaseReadRepository implements ConstraintOrderRepository
{
    public function __construct()
    {
        $this->model = new Order();
    }

    public function singleOrderSave(
        int $userId,
        string $uuid,
        int $productId,
        ?int $typeId,
        int $count,
        float $price,
        Location $consumeLocation
    ): Order {
        /** @var Order $order */
        $order = $this->getModel();
        $order->user_id = $userId;
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
        $userId = $items->getUserId();
        $payload = [];

        $items->getOrders()->each(function (DtoOrderObject $item) use (&$payload, $uuid, $userId) {
            array_push($payload, [
                'user_id'           => $userId,
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

    public function updateStatus(Order $order, StatusOrder $status): Order
    {
        $order->status = $status;
        $order->saveOrFail();
        return $order;
    }

    public function getOrders(array $orderIds, ?string $invoiceId = null, ?int $userId = null): Collection
    {
        $query = $this
            ->getModel()
            ->query()
            ->ids($orderIds);

        if ($invoiceId) {
            $query->invoiceId($invoiceId);
        }
        if ($userId) {
            $query->userId($userId);
        }

        return $query->get();
    }

    public function delete(array $orderIds): bool
    {
        return $this
            ->getModel()
            ->ids($orderIds)
            ->delete();
    }
    public function getByInvoiceId(string $invoiceId): Collection
    {
        return $this
            ->getModel()
            ->invoiceId($invoiceId)
            ->get();
    }

    public function deleteByInvoiceId(string $invoiceId): bool
    {
        return $this
            ->getModel()
            ->invoiceId($invoiceId)
            ->delete();
    }
}

<?php

namespace App\Dto;

use App\Enums\Location;
use App\Http\Requests\V1\User\Order\Store;
use Illuminate\Support\Collection;

class OrderList
{
    private Collection $order;
    private array $poolOrders;
    private string $uuid;
    private int $userId;

    public function __construct(Store $request)
    {
        $orders = $request->validated()['order'];
        $this->userId = $request->attributes->get('userId');
        $this->order = collect();

        foreach ($orders as $order) {
            $this->order->push(
                $this->fillPoolOrder(order: $order)
            );
        }
    }

    /**
     * @return Collection<OrderObject>
     */
    public function getOrders(): Collection
    {
        return $this->order;
    }

    public function getOrder(int $productId, ?int $typeId): OrderObject
    {
        $key = $this->poolKeys(productId: $productId, typeId: $typeId);
        return $this->poolOrders[$key];
    }

    public function setInvoiceId(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getInvoiceId(): string
    {
        return $this->uuid;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    private function fillPoolOrder(array $order): OrderObject
    {
        $key = $this->poolKeys(productId: $order['product_id'], typeId: $order['type_id'] ?? null);
        $this->poolOrders[$key] = new OrderObject(
            productId: $order['product_id'],
            typeId: $order['type_id'] ?? null,
            count: $order['count'],
            consumeLocation: Location::from($order['consume_location'])
        );

        return $this->poolOrders[$key];
    }

    private function poolKeys(int $productId, ?int $typeId)
    {
        return $productId . "-" . $typeId;
    }
}

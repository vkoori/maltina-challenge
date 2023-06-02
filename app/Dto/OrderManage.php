<?php

namespace App\Dto;

use App\Enums\StatusOrder;
use App\Models\Order;

class OrderManage
{
    private Order $order;

    public function __construct(private int $orderId, private StatusOrder $status)
    {
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getStatus(): StatusOrder
    {
        return $this->status;
    }
}

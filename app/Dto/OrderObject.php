<?php

namespace App\Dto;

use App\Enums\Location;
use App\Models\Order as ModelsOrder;

class OrderObject
{
    private float $price;
    private ModelsOrder $order;

    public function __construct(
        private int $productId,
        private ?int $typeId,
        private int $count,
        private Location $consumeLocation,
    ) {
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setOrder(ModelsOrder $order): void
    {
        $this->order = $order;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getOrder(): ModelsOrder
    {
        return $this->order;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getLocation(): Location
    {
        return $this->consumeLocation;
    }
}

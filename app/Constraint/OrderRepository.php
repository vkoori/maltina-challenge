<?php

namespace App\Constraint;

use App\Dto\OrderList as DtoOrderList;
use App\Enums\Location;
use App\Enums\StatusOrder;
use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepository extends BaseReadRepository
{
    public function singleOrderSave(
        int $userId,
        string $uuid,
        int $productId,
        ?int $typeId,
        int $count,
        float $price,
        Location $consumeLocation
    ): Order;
    public function bulkOrderSave(string $uuid, DtoOrderList $items): bool;
    public function updateStatus(Order $order, StatusOrder $status): Order;
    public function getOrders(array $orderIds, ?string $invoiceId = null, ?int $userId = null): Collection;
    public function delete(array $orderIds): bool;
}
